<?php

namespace App\Http\Controllers;

use App\Models\PembinaSiswa;
use App\Models\CatatanKasusSiswa;
use App\Models\Presensi;
use App\Models\DetailPresensi;
use App\Models\Siswa;
use App\Models\Rombel;
use App\Models\Walas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PembinaSiswaController extends Controller
{
    /**
     * Helper to retrieve currently authenticated Pembina Siswa.
     */
    protected function getAuthenticatedPembina(): PembinaSiswa
    {
        if (!session()->has('pembina_id') && !Auth::guard('pembinas')->check()) {
            abort(redirect()->route('loginpembinasiswa.index')->with('error', 'Silakan login sebagai Pembina Siswa terlebih dahulu.'));
        }

        $pembinaId = session('pembina_id') ?? Auth::guard('pembinas')->id();
        $pembina = PembinaSiswa::find($pembinaId);

        if (!$pembina) {
            Auth::guard('pembinas')->logout();
            session()->forget(['pembina_id', 'pembina_nama']);
            abort(redirect()->route('loginpembinasiswa.index')->with('error', 'Data Pembina Siswa tidak ditemukan.'));
        }

        return $pembina;
    }

    /**
     * Dashboard / Homepage Pembina Siswa.
     */
    public function index()
    {
        $pembina = $this->getAuthenticatedPembina();

        $totalCatatanKasus = CatatanKasusSiswa::count();
        $totalPresensi = Presensi::count();
        $totalSiswa = Siswa::count();
        $totalRombel = Rombel::count();

        $recentCases = CatatanKasusSiswa::with(['siswa.rombel', 'walas'])
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu')
            ->take(5)
            ->get();

        $recentPresensi = Presensi::with(['walas', 'detailPresensis'])
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        return view('homepagepembina.index', compact(
            'pembina',
            'totalCatatanKasus',
            'totalPresensi',
            'totalSiswa',
            'totalRombel',
            'recentCases',
            'recentPresensi'
        ));
    }

    /**
     * List all student case notes with filters and search.
     */
    public function catatankasusIndex(Request $request)
    {
        $pembina = $this->getAuthenticatedPembina();

        $query = CatatanKasusSiswa::with(['siswa.rombel.walas', 'walas'])
            ->orderByDesc('tanggal')
            ->orderByDesc('waktu');

        if ($request->filled('rombel_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('rombels_id', $request->rombel_id);
            });
        }

        if ($request->filled('siswa_id')) {
            $query->where('siswas_id', $request->siswa_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('kasus', 'like', "%{$kw}%")
                  ->orWhere('tindak_lanjut', 'like', "%{$kw}%")
                  ->orWhere('keterangan', 'like', "%{$kw}%")
                  ->orWhereHas('siswa', function ($sq) use ($kw) {
                      $sq->where('nama', 'like', "%{$kw}%");
                  });
            });
        }

        $catatankasus = $query->get();
        $rombels = Rombel::orderBy('nama_kelas')->get();
        $siswas = Siswa::orderBy('nama')->get();

        if ($request->has('export') && $request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfpembina.catatankasus', compact('pembina', 'catatankasus'));
            return $pdf->stream('Catatan_Kasus_Siswa_Pembina.pdf');
        }

        return view('homepagepembina.catatankasus.index', compact(
            'pembina',
            'catatankasus',
            'rombels',
            'siswas'
        ));
    }

    /**
     * Show form to write new case note for any student.
     */
    public function catatankasusCreate()
    {
        $pembina = $this->getAuthenticatedPembina();
        $rombels = Rombel::with('walas')->orderBy('nama_kelas')->get();
        $siswas = Siswa::with('rombel')->orderBy('nama')->get();

        return view('homepagepembina.catatankasus.create', compact('pembina', 'rombels', 'siswas'));
    }

    /**
     * Store new student case note.
     */
    public function catatankasusStore(Request $request)
    {
        $this->getAuthenticatedPembina();

        $validatedData = $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'kasus' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_kasus' => 'nullable',
            'file_kasus.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $siswa = Siswa::with('rombel')->findOrFail($request->siswas_id);
        $walasId = $siswa->rombel?->walas_id ?? (Walas::value('id') ?? 1);
        $validatedData['walas_id'] = $walasId;

        $uploadedPaths = [];
        if ($request->hasFile('file_kasus')) {
            $files = $request->file('file_kasus');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $uploadedPaths[] = $file->store('catatankasus', 'public');
                }
            }
        }

        $validatedData['file_kasus'] = !empty($uploadedPaths) ? $uploadedPaths : null;

        CatatanKasusSiswa::create($validatedData);

        return redirect()->route('pembina.catatankasus.index')->with('success', 'Catatan kasus siswa berhasil ditambahkan!');
    }

    /**
     * Show form to edit an existing case note.
     */
    public function catatankasusEdit($id)
    {
        $pembina = $this->getAuthenticatedPembina();
        $kasus = CatatanKasusSiswa::with('siswa.rombel')->findOrFail($id);
        $rombels = Rombel::with('walas')->orderBy('nama_kelas')->get();
        $siswas = Siswa::with('rombel')->orderBy('nama')->get();

        return view('homepagepembina.catatankasus.edit', compact('pembina', 'kasus', 'rombels', 'siswas'));
    }

    /**
     * Update an existing student case note.
     */
    public function catatankasusUpdate(Request $request, $id)
    {
        $this->getAuthenticatedPembina();
        $kasus = CatatanKasusSiswa::findOrFail($id);

        $validatedData = $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'kasus' => 'required|string|max:255',
            'tindak_lanjut' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'file_kasus' => 'nullable',
            'file_kasus.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        $siswa = Siswa::with('rombel')->findOrFail($request->siswas_id);
        $walasId = $siswa->rombel?->walas_id ?? $kasus->walas_id;
        $validatedData['walas_id'] = $walasId;

        $existingFiles = (array) $kasus->file_kasus;

        if ($request->hasFile('file_kasus')) {
            $files = $request->file('file_kasus');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $existingFiles[] = $file->store('catatankasus', 'public');
                }
            }
        }

        $validatedData['file_kasus'] = !empty($existingFiles) ? array_values(array_filter($existingFiles)) : null;

        $kasus->update($validatedData);

        return redirect()->route('pembina.catatankasus.index')->with('success', 'Catatan kasus berhasil diperbarui!');
    }

    /**
     * Delete a student case note.
     */
    public function catatankasusDestroy($id)
    {
        $this->getAuthenticatedPembina();
        $kasus = CatatanKasusSiswa::findOrFail($id);

        if (!empty($kasus->file_kasus) && is_array($kasus->file_kasus)) {
            foreach ($kasus->file_kasus as $file) {
                if (Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

        $kasus->delete();

        return redirect()->route('pembina.catatankasus.index')->with('success', 'Catatan kasus berhasil dihapus!');
    }

    /**
     * View all attendance records (daftar hadir siswa).
     */
    public function presensiIndex(Request $request)
    {
        $pembina = $this->getAuthenticatedPembina();

        $query = Presensi::with(['walas', 'detailPresensis.siswa'])
            ->orderByDesc('tanggal');

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $presensis = $query->get();
        $rombels = Rombel::orderBy('nama_kelas')->get();

        if ($request->has('export') && $request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('pdfpembina.presensi', compact('pembina', 'presensis'));
            return $pdf->stream('Daftar_Hadir_Siswa.pdf');
        }

        return view('homepagepembina.presensi.index', compact(
            'pembina',
            'presensis',
            'rombels'
        ));
    }

    /**
     * View detail attendance for a specific date and class.
     */
    public function presensiDetail($id)
    {
        $pembina = $this->getAuthenticatedPembina();

        $presensi = Presensi::with(['walas', 'detailPresensis.siswa'])->findOrFail($id);

        $summary = [
            'hadir' => $presensi->detailPresensis->where('status', 'hadir')->count(),
            'sakit' => $presensi->detailPresensis->where('status', 'sakit')->count(),
            'izin'  => $presensi->detailPresensis->where('status', 'izin')->count(),
            'alfa'  => $presensi->detailPresensis->where('status', 'alfa')->count(),
        ];

        return view('homepagepembina.presensi.detail', compact('pembina', 'presensi', 'summary'));
    }

    /**
     * Profile page.
     */
    public function profile()
    {
        $pembina = $this->getAuthenticatedPembina();
        return view('homepagepembina.profile.index', compact('pembina'));
    }

    /**
     * Edit profile form.
     */
    public function profileEdit($id = null)
    {
        $pembina = $this->getAuthenticatedPembina();
        return view('homepagepembina.profile.edit', compact('pembina'));
    }

    /**
     * Update profile data.
     */
    public function profileUpdate(Request $request, $id = null)
    {
        $pembina = $this->getAuthenticatedPembina();

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'nullable|string|max:20',
            'nip' => 'nullable|string|max:50',
            'no_wa' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
            'image_url' => 'nullable|image|max:5120',
        ]);

        $pembina->nama = $request->nama;
        $pembina->jenis_kelamin = $request->jenis_kelamin;
        $pembina->nip = $request->nip;
        $pembina->no_wa = $request->no_wa;

        if ($request->filled('password')) {
            $pembina->password = Hash::make($request->password);
        }

        if ($request->hasFile('image_url')) {
            if ($pembina->image_url && Storage::disk('public')->exists($pembina->image_url)) {
                Storage::disk('public')->delete($pembina->image_url);
            }
            $pembina->image_url = $request->file('image_url')->store('pembina/Photos', 'public');
        }

        $pembina->save();
        session(['pembina_nama' => $pembina->nama]);

        return redirect()->route('pembina.profile')->with('success', 'Profil Pembina Siswa berhasil diperbarui!');
    }
}
