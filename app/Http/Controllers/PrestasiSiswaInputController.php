<?php

namespace App\Http\Controllers;

use App\Models\PrestasiSiswa;
use App\Models\Rombel;
use App\Models\Siswa;
use App\Models\Walas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiSiswaInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $siswa = Auth::guard('siswas')->user();

        // Periksa apakah session 'walas_id' ada
        if (! session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'siswa_id' yang ada di session
        $siswa = Siswa::find(session('siswa_id'));

        // Periksa apakah data walas ditemukan
        if (! $siswa) {
            return redirect('/loginsiswa')->with('error', 'Data walas tidak ditemukan.');
        }

        // Ambil data siswa berdasarkan rombel_id yang sama dengan rombel
        $siswas = Siswa::all();

        // Ambil data prestasi siswa berdasarkan siswa_id dan siswas_id yang sedang login
        $prestasisiswa = PrestasiSiswa::where('siswas_id', $siswa->id)->get();

        // Kirim data walas, siswa, dan prestasi siswa ke view
        return view('homepagesiswa.inputprestasi.index', compact('siswa', 'prestasisiswa', 'siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (! session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $siswa = Siswa::with('rombel.walas')->find(session('siswa_id'));
        if (! $siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        return view('homepagesiswa.inputprestasi.create', compact('siswa'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $siswa = Siswa::with('rombel.walas')->find(session('siswa_id'));
        if (! $siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Validasi input
        $request->validate([
            'jenis_prestasi' => 'required|in:Akademik,Non-akademik,Non-Akademik',
            'nama_prestasi' => 'required|string|max:255',
            'mata_lomba' => 'nullable|string|max:255',
            'nama_pembimbing' => 'nullable|string|max:255',
            'tingkat' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'sertifikat_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,docx|max:10240',
            'dokumentasi_url' => 'nullable|array|max:10',
            'dokumentasi_url.*' => 'file|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Simpan file sertifikat ke storage
        $sertifikatPath = null;
        if ($request->hasFile('sertifikat_url')) {
            $sertifikatPath = $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public');
        }

        // Simpan multiple file foto dokumentasi ke storage
        $dokumentasiPaths = [];
        if ($request->hasFile('dokumentasi_url')) {
            $files = $request->file('dokumentasi_url');
            if (! is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $dokumentasiPaths[] = $file->store('prestasisiswa/Photos', 'public');
                }
            }
        }

        $jenisPrestasi = $request->jenis_prestasi === 'Non-Akademik'
            ? 'Non-akademik'
            : $request->jenis_prestasi;

        $walasId = $siswa->rombel->walas_id ?? $request->input('walas_id');
        $rombelsId = $siswa->rombels_id ?? $request->input('rombels_id');

        // Simpan data ke database
        PrestasiSiswa::create([
            'walas_id' => $walasId,
            'siswas_id' => $siswa->id,
            'rombels_id' => $rombelsId,
            'jenis_prestasi' => $jenisPrestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'mata_lomba' => $request->mata_lomba,
            'nama_pembimbing' => $request->nama_pembimbing,
            'tingkat' => $request->tingkat,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => ! empty($dokumentasiPaths) ? $dokumentasiPaths : null,
        ]);

        return redirect('/prestasisiswainput')->with('success', 'Data prestasi berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (! session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $siswa = Siswa::with('rombel.walas')->find(session('siswa_id'));
        if (! $siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        $prestasisiswa = PrestasiSiswa::findOrFail($id);

        return view('homepagesiswa.inputprestasi.edit', compact('prestasisiswa', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (! session()->has('siswa_id')) {
            return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        $siswa = Siswa::with('rombel.walas')->find(session('siswa_id'));
        if (! $siswa) {
            return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
        }

        $prestasisiswa = PrestasiSiswa::findOrFail($id);

        // Validasi input
        $request->validate([
            'jenis_prestasi' => 'required|in:Akademik,Non-akademik,Non-Akademik',
            'nama_prestasi' => 'required|string|max:255',
            'mata_lomba' => 'nullable|string|max:255',
            'nama_pembimbing' => 'nullable|string|max:255',
            'tingkat' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'tanggal' => 'required|date',
            'sertifikat_url' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,docx|max:10240',
            'dokumentasi_url' => 'nullable|array|max:10',
            'dokumentasi_url.*' => 'file|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Sertifikat
        if ($request->hasFile('sertifikat_url')) {
            if ($prestasisiswa->sertifikat_url && Storage::disk('public')->exists($prestasisiswa->sertifikat_url)) {
                Storage::disk('public')->delete($prestasisiswa->sertifikat_url);
            }
            $sertifikatPath = $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public');
        } else {
            $sertifikatPath = $prestasisiswa->sertifikat_url;
        }

        // Multiple Dokumentasi
        $currentDocs = is_array($prestasisiswa->dokumentasi_url)
            ? $prestasisiswa->dokumentasi_url
            : ($prestasisiswa->dokumentasi_url ? [$prestasisiswa->dokumentasi_url] : []);

        if ($request->has('form_has_docs')) {
            $keepDocs = $request->input('keep_docs', []);
            if (! is_array($keepDocs)) {
                $keepDocs = [];
            }
            foreach ($currentDocs as $doc) {
                if (! in_array($doc, $keepDocs)) {
                    if (Storage::disk('public')->exists($doc)) {
                        Storage::disk('public')->delete($doc);
                    }
                }
            }
            $finalDocs = array_values(array_intersect($currentDocs, $keepDocs));
        } else {
            if ($request->hasFile('dokumentasi_url')) {
                foreach ($currentDocs as $doc) {
                    if (Storage::disk('public')->exists($doc)) {
                        Storage::disk('public')->delete($doc);
                    }
                }
                $finalDocs = [];
            } else {
                $finalDocs = $currentDocs;
            }
        }

        if ($request->hasFile('dokumentasi_url')) {
            $newDocs = $request->file('dokumentasi_url');
            if (! is_array($newDocs)) {
                $newDocs = [$newDocs];
            }
            foreach ($newDocs as $doc) {
                if ($doc && $doc->isValid()) {
                    $finalDocs[] = $doc->store('prestasisiswa/Photos', 'public');
                }
            }
        }

        $walasId = $siswa->rombel->walas_id ?? $prestasisiswa->walas_id;
        $rombelsId = $siswa->rombels_id ?? $prestasisiswa->rombels_id;

        $prestasisiswa->update([
            'walas_id' => $walasId,
            'siswas_id' => $siswa->id,
            'rombels_id' => $rombelsId,
            'jenis_prestasi' => $request->jenis_prestasi === 'Non-Akademik' ? 'Non-akademik' : $request->jenis_prestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'mata_lomba' => $request->mata_lomba,
            'nama_pembimbing' => $request->nama_pembimbing,
            'tingkat' => $request->tingkat,
            'lokasi' => $request->lokasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => ! empty($finalDocs) ? $finalDocs : null,
        ]);

        return redirect('/prestasisiswainput')->with('success', 'Data prestasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function hapusprestasisiswainput(string $id)
    {
        $prestasisiswa = PrestasiSiswa::find($id);
        if ($prestasisiswa) {
            if ($prestasisiswa->sertifikat_url && Storage::disk('public')->exists($prestasisiswa->sertifikat_url)) {
                Storage::disk('public')->delete($prestasisiswa->sertifikat_url);
            }
            $docs = is_array($prestasisiswa->dokumentasi_url)
                ? $prestasisiswa->dokumentasi_url
                : ($prestasisiswa->dokumentasi_url ? [$prestasisiswa->dokumentasi_url] : []);
            foreach ($docs as $doc) {
                if ($doc && Storage::disk('public')->exists($doc)) {
                    Storage::disk('public')->delete($doc);
                }
            }
            $prestasisiswa->delete();

            return redirect('/prestasisiswainput')->with('success', 'Data Prestasi Berhasil Dihapus');
        }

        return redirect('/prestasisiswainput')->with('error', 'Data Prestasi not found!');
    }
}
