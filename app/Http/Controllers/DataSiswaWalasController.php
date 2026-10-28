<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\KeluarRombel;
use App\Support\AcademicYear;
use App\Imports\SiswaImport;
use App\Models\BiodataSiswa;
use App\Models\Walas;
use App\Http\Concerns\HasWalasAuth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DataSiswaWalasController extends Controller
{
    use HasWalasAuth;

    public function index()
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $siswa = DB::table('vwsiswas')
            ->leftJoin('keluar_rombels', 'vwsiswas.siswa_id', '=', 'keluar_rombels.siswa_id')
            ->where('vwsiswas.nama_kelas', $rombel->nama_kelas)
            ->select('vwsiswas.*', 'keluar_rombels.keterangan')
            ->get();

        $rombels = Rombel::with('walas')->get();

        return view("homepagegtk.siswadata", compact('siswa', 'rombels', 'rombel', 'walas'));
    }

    public function import(Request $request)
    {
        set_time_limit(300);

        try {
            $request->validate([
                'file' => 'required|file|mimes:xlsx,csv,txt|max:10240',
            ]);

            Excel::import(new SiswaImport, $request->file('file'));
        } catch (ValidationException $exception) {
            return back()->with('error', collect($exception->errors())->flatten()->first());
        }

        return redirect('/siswadata')->with('success', 'Data siswa berhasil diimpor.');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_siswa.xlsx');
        if (! file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }
        return response()->download($pathToFile);
    }

    public function biodata($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $this->siswaDiRombel($id);

        $siswa = Siswa::find($id);
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan');
        }

        $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->get();
        if ($biodatas->isEmpty()) {
            $targetUrl = \Illuminate\Support\Facades\Route::has('homepagegtk.createbiodata')
                ? route('homepagegtk.createbiodata', $siswa->id)
                : url('/siswabiodata/' . $siswa->id . '/create');
            return redirect($targetUrl)
                ->with('info', 'Biodata untuk ' . $siswa->nama . ' belum ada. Silakan buat atau lengkapi biodata berikut.');
        }

        foreach ($biodatas as $item) {
            $item->fotorumah_base64 = $this->convertToBase64($item->fotorumah_url);
        }

        if (request()->has('export') && request()->get('export') === 'pdf') {
            $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->first();
            $biodatas->fotorumah_base64 = $this->convertToBase64($biodatas->fotorumah_url);
            $pdf = Pdf::loadView('pdf.pdfbiodatasiswa', compact('siswa', 'biodatas', 'walas', 'rombel'));
            return $pdf->stream('Biodata_Siswa.pdf');
        }

        $role = 'walas';
        $backUrl = route('siswadata.index');
        $editUrl = route('homepagegtk.editbiodata', $biodatas->first()->id);
        $pdfUrl = route('homepagegtk.biodatasiswa', ['id' => $siswa->id, 'export' => 'pdf']);

        return view('homepagegtk.biodatasiswa', compact('siswa', 'biodatas', 'walas', 'rombel', 'role', 'backUrl', 'editUrl', 'pdfUrl'));
    }

    private function convertToBase64($path)
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

    public function createbiodata($id)
    {
        $walas = $this->getAuthenticatedWalas();
        $this->siswaDiRombel($id);

        $siswa = Siswa::with('rombel.walas')->findOrFail($id);
        $biodata = BiodataSiswa::where('siswas_id', $siswa->id)->first();
        if ($biodata) {
            return redirect()->route('homepagegtk.editbiodata', $biodata->id);
        }

        $nowalas = $siswa->rombel ? $siswa->rombel->walas : $walas;
        $walasList = Walas::select('id', 'nama')->get();
        $no_wa_walas = $nowalas?->no_wa ?? 'Nomor tidak tersedia';

        $biodata = new BiodataSiswa([
            'siswas_id' => $siswa->id,
            'walas_id' => $siswa->rombel?->walas_id ?? $walas->id,
            'nama_lengkap' => $siswa->nama,
            'jenis_kelamin' => $siswa->jenis_kelamin ?? 'Laki-laki',
            'no_wa' => $siswa->no_wa ?? '',
            'kelas' => $siswa->rombel?->tingkat ?? ($siswa->rombel?->nama_kelas ?? 'X'),
            'kompetensi' => $siswa->rombel?->kompetensi ?? 'SIJA',
            'tahun_masuk' => '2025',
            'nis' => sprintf('2025%04d', $siswa->id),
            'nisn' => sprintf('000%08d', 10000000 + $siswa->id),
        ]);

        $role = 'walas';
        $isCreate = true;
        $formAction = route('homepagegtk.storebiodata', $siswa->id);
        $backUrl = route('siswadata.index');

        return view('homepagegtk.editbiodata', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas', 'isCreate', 'formAction', 'backUrl', 'role'));
    }

    public function storebiodata(Request $request, $id)
    {
        $walas = $this->getAuthenticatedWalas();
        $this->siswaDiRombel($id);

        $siswa = Siswa::with('rombel')->findOrFail($id);

        $validatedData = $this->validateBiodataInput($request);

        $fotoRumahPath = $request->hasFile('fotorumah_url')
            ? $request->file('fotorumah_url')->store('images/photos', 'public')
            : null;

        unset($validatedData['fotorumah_url']);

        $defaults = $this->getDefaultBiodataAttributes($siswa, $walas);
        $biodataData = array_merge($defaults, array_filter($validatedData, fn($v) => !is_null($v)));
        $biodataData['fotorumah_url'] = $fotoRumahPath;

        $biodata = BiodataSiswa::updateOrCreate(['siswas_id' => $siswa->id], $biodataData);

        $walasId = $siswa->rombel?->walas_id ?? ($biodata->walas_id ?? $walas->id);
        \App\Models\DaftarPesertaDidik::updateOrCreate(
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

        return redirect()->route('homepagegtk.biodatasiswa', $siswa->id)
            ->with('success', 'Biodata siswa berhasil dibuat!');
    }

    public function editbiodata($id)
    {
        $walas = $this->getAuthenticatedWalas();

        $biodata = BiodataSiswa::find($id);
        if (! $biodata) {
            return redirect('/siswadata')->with('error', 'Biodata siswa tidak ditemukan.');
        }

        $this->siswaDiRombel($biodata->siswas_id);

        $siswa = Siswa::with('rombel.walas')->find($biodata->siswas_id);
        if (! $siswa) {
            return redirect('/siswadata')->with('error', 'Data siswa tidak ditemukan.');
        }

        $nowalas = $siswa->rombel ? $siswa->rombel->walas : null;
        $walasList = Walas::select('id', 'nama')->get();
        $walasData = Walas::find($biodata->walas_id) ?? $nowalas;
        $no_wa_walas = $walasData?->no_wa ?? 'Nomor tidak tersedia';

        $role = 'walas';
        $isCreate = false;
        $formAction = route('homepagegtk.updatebiodata', $biodata->id);
        $backUrl = route('homepagegtk.biodatasiswa', $biodata->siswas_id);

        return view('homepagegtk.editbiodata', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas', 'isCreate', 'formAction', 'backUrl', 'role'));
    }

    public function updatebiodata(Request $request, $id)
    {
        $walas = $this->getAuthenticatedWalas();
        $biodata = BiodataSiswa::findOrFail($id);

        $this->siswaDiRombel($biodata->siswas_id);

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

        $walasId = $biodata->walas_id ?? $walas->id;
        \App\Models\DaftarPesertaDidik::updateOrCreate(
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

        return redirect()->route('homepagegtk.biodatasiswa', $biodata->siswas_id)
            ->with('success', 'Data Diri Siswa berhasil diperbarui!');
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
            'siswas_id' => 'nullable|integer',
            'nama_lengkap' => 'nullable|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:10',
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
            'nisn' => 'nullable|string|max:20',
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

    protected function getDefaultBiodataAttributes(Siswa $siswa, Walas $walas): array
    {
        return [
            'siswas_id' => $siswa->id,
            'walas_id' => $siswa->rombel?->walas_id ?? $walas->id,
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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'rombels_id' => 'required',
            'jenis_kelamin' => 'required',
            'no_wa' => 'required|numeric',
            'image_url' => 'nullable|image|max:5000',
            'password' => 'required|string|min:8',
            'status' => 'required',
        ]);

        $imagePath = $request->hasFile('image_url')
            ? $request->file('image_url')->store('siswafoto/Photos', 'public')
            : null;

        $siswa = Siswa::create([
            'nama' => $request->nama,
            'rombels_id' => $request->rombels_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_wa' => $request->no_wa,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'image_url' => $imagePath,
        ]);

        $rombel = Rombel::find($request->rombels_id);
        if ($rombel) {
            \App\Services\DaftarPesertaDidikService::syncRombel($rombel);
        }

        return redirect()->back()->with(['success' => 'Data Siswa berhasil ditambahkan!']);
    }

    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $this->siswaDiRombel($id);

        $siswa = DB::table('vwsiswas')->where('siswa_id', $id)->first();
        $rombels = Rombel::with('walas')->get();
        return view('homepagegtk.editsiswa', compact('siswa', 'rombels'));
    }

    public function update(Request $request, $id)
    {
        $this->siswaDiRombel($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'rombels_id' => 'required',
            'jenis_kelamin' => 'required',
            'no_wa' => 'required|numeric',
            'image_url' => 'nullable|image|max:5000',
            'password' => 'nullable|string|min:8',
            'status' => 'required',
        ]);

        $siswa = Siswa::findOrFail($id);

        if ($request->hasFile('image_url')) {
            if ($siswa->image_url) {
                Storage::delete('public/' . $siswa->image_url);
            }
            $siswa->image_url = $request->file('image_url')->store('siswafoto/Photos', 'public');
        }

        $siswa->fill($request->except(['image_url', 'password']));
        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }
        $siswa->save();

        $rombel = Rombel::find($siswa->rombels_id);
        if ($rombel) {
            \App\Services\DaftarPesertaDidikService::syncRombel($rombel);
        }

        return redirect('/siswadata')->with('success', 'Data siswa Berhasil di Edit');
    }

    public function hapussiswa(string $id)
    {
        $this->siswaDiRombel($id);

        $siswa = Siswa::find($id);
        if ($siswa) {
            $siswa->delete();
            return redirect('/siswadata')->with('success', 'siswa data Berhasil Dihapus ');
        }
        return redirect('/siswadata')->with('error', 'siswa not found!');
    }

    public function siswadata_search(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $keywords = explode(' ', $request->keyword);

        $siswa = DB::table('vwsiswas')
            ->where('nama_kelas', $rombel->nama_kelas)
            ->where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where('siswa_nama', 'LIKE', '%' . $keyword . '%');
                }
            })
            ->get();

        $rombels = Rombel::with('walas')->get();

        return view('homepagegtk.siswadata', compact('walas', 'rombels', 'rombel', 'siswa'));
    }

    public function saveKeterangan(Request $request)
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $this->getWalasRombel();

        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'keterangan' => 'required|in:naik_kelas,tidak_naik_kelas,pindah_sekolah',
        ]);

        $siswa = Siswa::find($request->siswa_id);

        $this->siswaDiRombel($siswa->id);
        $period = AcademicYear::current();

        $keluarRombel = KeluarRombel::create([
            'siswa_id' => $siswa->id,
            'keterangan' => $request->keterangan,
            'rombels_id' => $rombel->id,
            'academic_year' => $period['year'],
            'semester' => $period['status'],
        ]);

        return response()->json(['success' => 'Data berhasil disimpan!', 'keluarRombel' => $keluarRombel]);
    }
}
