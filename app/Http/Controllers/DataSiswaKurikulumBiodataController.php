<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Models\BiodataSiswa;
use App\Models\DaftarPesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DataSiswaKurikulumBiodataController extends Controller
{
    protected function getAuthenticatedKurikulum(): Kurikulum
    {
        $kurikulum = Auth::guard('kurikulums')->user();
        if (! $kurikulum && session('kurikulum_id')) {
            $kurikulum = Kurikulum::find(session('kurikulum_id'));
        }

        if (! $kurikulum) {
            abort(redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.'));
        }

        return $kurikulum;
    }

    public function show(Request $request, $id)
    {
        $kurikulum = $this->getAuthenticatedKurikulum();

        $siswa = Siswa::with('rombel.walas')->find($id);
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }

        $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->get();
        if ($biodatas->isEmpty()) {
            $targetUrl = \Illuminate\Support\Facades\Route::has('kurikulum.createbiodata')
                ? route('kurikulum.createbiodata', $siswa->id)
                : url('/kurikulum/siswa/biodata/' . $siswa->id . '/create');
            return redirect($targetUrl)
                ->with('info', 'Biodata untuk ' . $siswa->nama . ' belum ada. Silakan buat biodata siswa berikut.');
        }

        foreach ($biodatas as $item) {
            $item->fotorumah_base64 = $this->convertToBase64($item->fotorumah_url);
        }

        $walas = $siswa->rombel?->walas ?? Walas::first();
        $rombel = $siswa->rombel ?? new Rombel(['nama_kelas' => 'X SIJA 1']);

        if ($request->has('export') && $request->get('export') === 'pdf') {
            $biodataSingle = $biodatas->first();
            $biodataSingle->fotorumah_base64 = $this->convertToBase64($biodataSingle->fotorumah_url);
            $pdf = Pdf::loadView('pdf.pdfbiodatasiswa', [
                'siswa' => $siswa,
                'biodatas' => $biodataSingle,
                'walas' => $walas,
                'rombel' => $rombel,
            ]);
            return $pdf->stream('Biodata_' . str_replace(' ', '_', $siswa->nama) . '.pdf');
        }

        $backUrl = route('rombel.showDetailKurikulum', $rombel->walas_id ?? 1);
        $editUrl = route('kurikulum.editbiodata', $biodatas->first()->id);
        $pdfUrl = route('kurikulum.biodatasiswa', ['id' => $siswa->id, 'export' => 'pdf']);
        $role = 'kurikulum';

        return view('homepagegtk.biodatasiswa', compact('siswa', 'biodatas', 'walas', 'rombel', 'kurikulum', 'backUrl', 'editUrl', 'pdfUrl', 'role'));
    }

    public function create($id)
    {
        $kurikulum = $this->getAuthenticatedKurikulum();

        $siswa = Siswa::with('rombel.walas')->findOrFail($id);
        $biodata = BiodataSiswa::where('siswas_id', $siswa->id)->first();
        if ($biodata) {
            return redirect()->route('kurikulum.editbiodata', $biodata->id);
        }

        $walasList = Walas::select('id', 'nama')->get();
        $rombel = $siswa->rombel;
        $nowalas = $rombel ? $rombel->walas : null;
        $walas = $nowalas ?? Walas::first();
        $no_wa_walas = $walas?->no_wa ?? 'Nomor tidak tersedia';

        $biodata = new BiodataSiswa([
            'siswas_id' => $siswa->id,
            'walas_id' => $rombel?->walas_id ?? ($walas?->id ?? 1),
            'nama_lengkap' => $siswa->nama,
            'jenis_kelamin' => $siswa->jenis_kelamin ?? 'Laki-laki',
            'no_wa' => $siswa->no_wa ?? '',
            'kelas' => $rombel?->tingkat ?? ($rombel?->nama_kelas ?? 'X'),
            'kompetensi' => $rombel?->kompetensi ?? 'SIJA',
            'tahun_masuk' => '2025',
            'nis' => sprintf('2025%04d', $siswa->id),
            'nisn' => sprintf('000%08d', 10000000 + $siswa->id),
        ]);

        $role = 'kurikulum';
        $isCreate = true;
        $formAction = route('kurikulum.storebiodata', $siswa->id);
        $backUrl = route('rombel.showDetailKurikulum', $rombel?->walas_id ?? 1);

        return view('homepagegtk.editbiodata', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas', 'kurikulum', 'isCreate', 'formAction', 'backUrl', 'role'));
    }

    public function store(Request $request, $id)
    {
        $kurikulum = $this->getAuthenticatedKurikulum();
        $siswa = Siswa::with('rombel')->findOrFail($id);

        $validatedData = $this->validateBiodataInput($request);

        $fotoRumahPath = $request->hasFile('fotorumah_url')
            ? $request->file('fotorumah_url')->store('images/photos', 'public')
            : null;

        unset($validatedData['fotorumah_url']);

        $defaults = $this->getDefaultBiodataAttributes($siswa);
        $biodataData = array_merge($defaults, array_filter($validatedData, fn($v) => !is_null($v)));
        $biodataData['fotorumah_url'] = $fotoRumahPath;

        $biodata = BiodataSiswa::updateOrCreate(['siswas_id' => $siswa->id], $biodataData);

        $walasId = $siswa->rombel?->walas_id ?? ($biodata->walas_id ?? 1);
        DaftarPesertaDidik::updateOrCreate(
            ['nama_siswa' => $siswa->id],
            [
                'walas_id' => $walasId,
                'nis' => $biodata->nis,
                'nisn' => $biodata->nisn,
                'jenis_kelamin' => $biodata->jenis_kelamin ?? 'Laki-laki',
                'keterangan' => 'Aktif',
                'tanggal' => now()->toDateString(),
            ]
        );

        return redirect()->route('kurikulum.biodatasiswa', $siswa->id)
            ->with('success', 'Biodata siswa berhasil dibuat oleh Kurikulum!');
    }

    public function edit($id)
    {
        $kurikulum = $this->getAuthenticatedKurikulum();

        $biodata = BiodataSiswa::findOrFail($id);
        $siswa = Siswa::with('rombel.walas')->findOrFail($biodata->siswas_id);

        $walasList = Walas::select('id', 'nama')->get();
        $nowalas = $siswa->rombel ? $siswa->rombel->walas : null;
        $walasData = Walas::find($biodata->walas_id) ?? $nowalas;
        $no_wa_walas = $walasData?->no_wa ?? 'Nomor tidak tersedia';
        $walas = $walasData;

        $role = 'kurikulum';
        $isCreate = false;
        $formAction = route('kurikulum.updatebiodata', $biodata->id);
        $backUrl = route('kurikulum.biodatasiswa', $siswa->id);

        return view('homepagegtk.editbiodata', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas', 'kurikulum', 'isCreate', 'formAction', 'backUrl', 'role'));
    }

    public function update(Request $request, $id)
    {
        $kurikulum = $this->getAuthenticatedKurikulum();
        $biodata = BiodataSiswa::findOrFail($id);

        $validatedData = $this->validateBiodataInput($request);

        // Jika sudah pernah terisi dan input kosong, pertahankan data lama (tidak usah masukkan lagi)
        if (empty($validatedData['pekerjaan_ayah']) && !empty($biodata->pekerjaan_ayah)) {
            unset($validatedData['pekerjaan_ayah']);
        }
        if (empty($validatedData['pekerjaan_ibu']) && !empty($biodata->pekerjaan_ibu)) {
            unset($validatedData['pekerjaan_ibu']);
        }
        if (empty($validatedData['pendapatan_ortu']) && !empty($biodata->pendapatan_ortu)) {
            unset($validatedData['pendapatan_ortu']);
        }

        if ($request->hasFile('fotorumah_url')) {
            if ($biodata->fotorumah_url && Storage::disk('public')->exists($biodata->fotorumah_url)) {
                Storage::disk('public')->delete($biodata->fotorumah_url);
            }
            $biodata->fotorumah_url = $request->file('fotorumah_url')->store('images/photos', 'public');
        }

        unset($validatedData['fotorumah_url']);

        $biodata->fill(array_filter($validatedData, fn($v) => !is_null($v)));
        $biodata->save();

        $walasId = $biodata->walas_id ?? 1;
        DaftarPesertaDidik::updateOrCreate(
            ['nama_siswa' => $biodata->siswas_id],
            [
                'walas_id' => $walasId,
                'nis' => $biodata->nis,
                'nisn' => $biodata->nisn,
                'jenis_kelamin' => $biodata->jenis_kelamin ?? 'Laki-laki',
                'keterangan' => 'Aktif',
                'tanggal' => now()->toDateString(),
            ]
        );

        return redirect()->route('kurikulum.biodatasiswa', $biodata->siswas_id)
            ->with('success', 'Biodata siswa berhasil diperbarui oleh Kurikulum!');
    }

    protected function validateBiodataInput(Request $request): array
    {
        if ($request->pekerjaan_ayah === 'Lainnya' && $request->has('pekerjaan_ayah_lainnya')) {
            $request->merge(['pekerjaan_ayah' => $request->pekerjaan_ayah_lainnya]);
        }
        if ($request->pekerjaan_ibu === 'Lainnya' && $request->has('pekerjaan_ibu_lainnya')) {
            $request->merge(['pekerjaan_ibu' => $request->pekerjaan_ibu_lainnya]);
        }

        return $request->validate([
            'walas_id' => 'nullable|integer',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string|max:10',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string|max:255',
            'alamat_maps' => 'nullable|string|max:5000',
            'fotorumah_url' => 'nullable',
            'jalur_masuk' => 'nullable|string|max:100',
            'jarak_rumah' => 'nullable|string|max:50',
            'transportasi_sekolah' => 'nullable|string|max:50',
            'transportasi_rumah' => 'nullable|string|max:50',
            'agama' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'anak_ke' => 'nullable|integer',
            'jumlah_saudara' => 'nullable|integer',
            'no_wa' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'nis' => 'nullable|string|max:20',
            'nisn' => 'required|string|max:20',
            'kelas' => 'nullable|string|max:50',
            'kompetensi' => 'nullable|string|max:100',
            'tahun_masuk' => 'nullable|string|max:4',
            'nama_ayah' => 'nullable|string|max:255',
            'pekerjaan_ayah' => 'nullable|string|max:255',
            'tempat_lahir_ayah' => 'nullable|string|max:255',
            'tanggal_lahir_ayah' => 'nullable|date',
            'alamat_ayah' => 'nullable|string|max:255',
            'no_wa_ayah' => 'nullable|string|max:15',
            'nama_ibu' => 'nullable|string|max:255',
            'pekerjaan_ibu' => 'nullable|string|max:255',
            'tempat_lahir_ibu' => 'nullable|string|max:255',
            'tanggal_lahir_ibu' => 'nullable|date',
            'alamat_ibu' => 'nullable|string|max:255',
            'no_wa_ibu' => 'nullable|string|max:15',
            'pendapatan_ortu' => 'nullable|string|max:80',
            'namasekolah_asal' => 'nullable|string|max:255',
            'alamat_sekolah' => 'nullable|string|max:255',
            'tahun_lulus' => 'nullable|string|max:4',
            'riwayat_penyakit' => 'nullable|string|max:255',
            'alergi' => 'nullable|string|max:255',
            'prestasi_akademik' => 'nullable|string|max:255',
            'prestasi_non_akademik' => 'nullable|string|max:255',
            'pengalaman_ekskul' => 'nullable|string|max:255',
            'kepribadian' => 'nullable|string|max:255',
        ]);
    }

    protected function getDefaultBiodataAttributes(Siswa $siswa): array
    {
        return [
            'siswas_id' => $siswa->id,
            'walas_id' => $siswa->rombel?->walas_id ?? 1,
            'nama_lengkap' => $siswa->nama,
            'jenis_kelamin' => $siswa->jenis_kelamin ?? 'Laki-laki',
            'tempat_lahir' => '-',
            'tanggal_lahir' => '2008-01-01',
            'alamat' => '-',
            'alamat_maps' => '-',
            'jarak_rumah' => '-',
            'transportasi_sekolah' => '-',
            'transportasi_rumah' => '-',
            'agama' => 'Islam',
            'kewarganegaraan' => 'Indonesia',
            'anak_ke' => '1',
            'jumlah_saudara' => '1',
            'no_wa' => $siswa->no_wa ?? '081234567890',
            'email' => strtolower(str_replace(' ', '.', $siswa->nama)) . '@student.sch.id',
            'nis' => sprintf('2025%04d', $siswa->id),
            'nisn' => sprintf('000%08d', 10000000 + $siswa->id),
            'kelas' => $siswa->rombel?->tingkat ?? 'X',
            'kompetensi' => $siswa->rombel?->kompetensi ?? 'SIJA',
            'tahun_masuk' => '2025',
            'nama_ayah' => '-',
            'pekerjaan_ayah' => '-',
            'tempat_lahir_ayah' => '-',
            'tanggal_lahir_ayah' => '1980-01-01',
            'alamat_ayah' => '-',
            'no_wa_ayah' => '081234567890',
            'nama_ibu' => '-',
            'pekerjaan_ibu' => '-',
            'tempat_lahir_ibu' => '-',
            'tanggal_lahir_ibu' => '1982-01-01',
            'alamat_ibu' => '-',
            'no_wa_ibu' => '081234567890',
            'pendapatan_ortu' => 'Rp1.000.000,00 - Rp3.000.000,00',
            'namasekolah_asal' => '-',
            'alamat_sekolah' => '-',
            'tahun_lulus' => '2024',
            'riwayat_penyakit' => 'Tidak ada',
            'alergi' => 'Tidak ada',
            'prestasi_akademik' => 'Tidak ada',
            'prestasi_non_akademik' => 'Tidak ada',
            'pengalaman_ekskul' => 'Tidak ada',
            'kepribadian' => 'Baik',
        ];
    }

    protected function convertToBase64($path)
    {
        if (empty($path) || is_array($path)) {
            return null;
        }

        if (str_starts_with($path, 'data:')) {
            return $path;
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return null;
        }

        $cleanPath = ltrim(str_replace('\\', '/', (string) $path), '/');
        $fullPath = storage_path('app/public/' . $cleanPath);

        if (! is_file($fullPath)) {
            $fallbackPath = storage_path('app/' . $cleanPath);
            if (! is_file($fallbackPath)) {
                return null;
            }
            $fullPath = $fallbackPath;
        }

        try {
            $imageData = @file_get_contents($fullPath);
            if ($imageData === false) {
                return null;
            }

            $mimeType = mime_content_type($fullPath) ?: 'application/octet-stream';
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function updateNisNisn(Request $request, $id)
    {
        $kurikulum = $this->getAuthenticatedKurikulum();

        $daftar = DaftarPesertaDidik::findOrFail($id);

        $validated = $request->validate([
            'nis' => 'nullable|string|max:50',
            'nisn' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|string|in:Laki-laki,Perempuan',
            'keterangan' => 'nullable|string|max:100',
        ]);

        $daftar->update([
            'nis' => $validated['nis'] ?? $daftar->nis,
            'nisn' => $validated['nisn'] ?? $daftar->nisn,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? $daftar->jenis_kelamin,
            'keterangan' => $validated['keterangan'] ?? $daftar->keterangan,
        ]);

        if ($daftar->nama_siswa) {
            $siswa = Siswa::find($daftar->nama_siswa);
            if ($siswa) {
                if (!empty($validated['jenis_kelamin'])) {
                    $siswa->update(['jenis_kelamin' => $validated['jenis_kelamin']]);
                }

                $biodata = BiodataSiswa::where('siswas_id', $siswa->id)->first();
                if ($biodata) {
                    $biodata->update([
                        'nis' => $validated['nis'] ?? $biodata->nis,
                        'nisn' => $validated['nisn'] ?? $biodata->nisn,
                        'jenis_kelamin' => $validated['jenis_kelamin'] ?? $biodata->jenis_kelamin,
                    ]);
                } else {
                    $defaults = $this->getDefaultBiodataAttributes($siswa);
                    $defaults['nis'] = $validated['nis'] ?? $daftar->nis;
                    $defaults['nisn'] = $validated['nisn'] ?? $daftar->nisn;
                    if (!empty($validated['jenis_kelamin'])) {
                        $defaults['jenis_kelamin'] = $validated['jenis_kelamin'];
                    }
                    BiodataSiswa::create($defaults);
                }
            }
        }

        return redirect()->back()->with('success', 'Data NIS & NISN siswa berhasil diperbarui!');
    }
}
