<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kurikulum;
use App\Models\PrestasiSiswa;
use App\Models\RekapitulasiJumlahSiswa;
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
       if (!session()->has('siswa_id')) {
           return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
       }
       
       // Ambil data walas berdasarkan 'siswa_id' yang ada di session
       $siswa = Siswa::find(session('siswa_id'));
       
       // Periksa apakah data walas ditemukan
       if (!$siswa) {
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
    // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
       $siswa = Auth::guard('siswas')->user();
        
       // Periksa apakah session 'walas_id' ada
       if (!session()->has('siswa_id')) {
           return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
       }
       
       // Ambil data walas berdasarkan 'siswa_id' yang ada di session
       $siswa = Siswa::find(session('siswa_id'));
       
       // Periksa apakah data walas ditemukan
       if (!$siswa) {
           return redirect('/loginsiswa')->with('error', 'Data walas tidak ditemukan.');
       }

    // Ambil data rombel berdasarkan 'walas_id'
    $rombel = Rombel::all();

    // Ambil seluruh data walas
    $walas = Walas::all();

    // Kirim data siswa yang login, walas, siswa dalam rombel, dan rombel ke view
    return view('homepagesiswa.inputprestasi.create', compact('siswa', 'walas', 'siswa', 'rombel'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
       $siswa = Auth::guard('siswas')->user();
        
       // Periksa apakah session 'walas_id' ada
       if (!session()->has('siswa_id')) {
           return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
       }
       
       // Ambil data walas berdasarkan 'siswa_id' yang ada di session
       $siswa = Siswa::find(session('siswa_id'));
       
       // Periksa apakah data walas ditemukan
       if (!$siswa) {
           return redirect('/loginsiswa')->with('error', 'Data walas tidak ditemukan.');
       }

        // Validasi input
        $validatedData = $request->validate([
            'walas_id' => 'required|exists:walas,id',
            'siswas_id' => 'required|exists:siswas,id', // Pastikan siswa valid
            'rombels_id' => 'required',
            'jenis_prestasi' => 'required|in:Akademik,Non-akademik,Non-Akademik',
            'nama_prestasi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'sertifikat_url' => 'nullable|mimes:jpeg,png,jpg,gif,pdf,docx|max:2048',
            'dokumentasi_url' => 'nullable|mimes:jpeg,png,jpg,gif|max:1024',
        ]);

        // Simpan file ke storage
        if ($request->hasFile('sertifikat_url')) {
            $sertifikatPath = $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public'); // Simpan di storage/app/public/images
        }

         // Simpan file ke storage
         if ($request->hasFile('dokumentasi_url')) {
            $dokumentasiPath = $request->file('dokumentasi_url')->store('prestasisiswa/Photos', 'public'); // Simpan di storage/app/public/images
        }

        $jenisPrestasi = $request->jenis_prestasi === 'Non-Akademik'
            ? 'Non-akademik'
            : $request->jenis_prestasi;

        // Simpan data ke database
        PrestasiSiswa::create([
            'walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'rombels_id' => $request->rombels_id,
            'jenis_prestasi' => $jenisPrestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => $dokumentasiPath, // Simpan path file di database
        ]);

        return redirect('/prestasisiswainput')->with('success', 'Data berhasil disimpan.');
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
       // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
       $siswa = Auth::guard('siswas')->user();
        
       // Periksa apakah session 'walas_id' ada
       if (!session()->has('siswa_id')) {
           return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
       }
       
       // Ambil data walas berdasarkan 'siswa_id' yang ada di session
       $siswa = Siswa::find(session('siswa_id'));
       
       // Periksa apakah data walas ditemukan
       if (!$siswa) {
           return redirect('/loginsiswa')->with('error', 'Data walas tidak ditemukan.');
       }

        $rombel = Rombel::all();

        // Ambil seluruh data walas
        $walas = Walas::all();

        $prestasisiswa = PrestasiSiswa::findOrFail($id);

        // Kirim data ke view
        return view('homepagesiswa.inputprestasi.edit', compact('walas', 'rombel', 'prestasisiswa', 'siswa'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
     // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $siswa = Auth::guard('siswas')->user();
        
     // Periksa apakah session 'walas_id' ada
     if (!session()->has('siswa_id')) {
         return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
     }
     
     // Ambil data walas berdasarkan 'siswa_id' yang ada di session
     $siswa = Siswa::find(session('siswa_id'));
     
     // Periksa apakah data walas ditemukan
     if (!$siswa) {
         return redirect('/loginsiswa')->with('error', 'Data walas tidak ditemukan.');
     }

    // Ambil data DaftarPesertaDidik yang akan diedit
    $prestasisiswa = PrestasiSiswa::findOrFail($id);

    // Validasi input
    $validatedData = $request->validate([
        'walas_id' => 'required|exists:walas,id',
        'siswas_id' => 'required|exists:siswas,id', // Pastikan siswa valid
        'rombels_id' => 'required',
        'jenis_prestasi' => 'required|in:Akademik,Non-akademik,Non-Akademik',
        'nama_prestasi' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'sertifikat_url' => 'nullable',
        'dokumentasi_url' => 'nullable',
    ]);

    if ($request->hasFile('sertifikat_url')) {
        // Hapus file yang lama jika ada
        if ($prestasisiswa->sertifikat_url && Storage::exists('public/' . $prestasisiswa->sertifikat_url)) {
            Storage::delete('public/' . $prestasisiswa->sertifikat_url);
        }
        $sertifikatPath = $request->file('sertifikat_url')->store('prestasisiswa/Photos', 'public');  // simpan di storage/app/public/images
    } else {
        $sertifikatPath = $prestasisiswa->sertifikat_url;  // Jika tidak ada perubahan, gunakan file lama
    }

    if ($request->hasFile('dokumentasi_url')) {
        // Hapus file yang lama jika ada
        if ($prestasisiswa->dokumentasi_url && Storage::exists('public/' . $prestasisiswa->dokumentasi_url)) {
            Storage::delete('public/' . $prestasisiswa->dokumentasi_url);
        }
        $dokumentasiPath = $request->file('dokumentasi_url')->store('prestasisiswa/Photos', 'public');  // simpan di storage/app/public/images
    } else {
        $dokumentasiPath = $prestasisiswa->dokumentasi_url;  // Jika tidak ada perubahan, gunakan file lama
    }

    // Update data HomeVisit
    $prestasisiswa->update([
            'walas_id' => $request->walas_id,
            'siswas_id' => $request->siswas_id,
            'rombels_id' => $request->rombels_id,
            'jenis_prestasi' => $request->jenis_prestasi === 'Non-Akademik'
                ? 'Non-akademik'
                : $request->jenis_prestasi,
            'nama_prestasi' => $request->nama_prestasi,
            'tanggal' => $request->tanggal,
            'sertifikat_url' => $sertifikatPath,
            'dokumentasi_url' => $dokumentasiPath, // 
    ]);


    return redirect('/prestasisiswainput')->with('success', 'Data berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapusprestasisiswainput(string $id)
    {
        $prestasisiswa = PrestasiSiswa::find($id);
        if ($prestasisiswa) {
            $prestasisiswa->delete();
            return redirect('/prestasisiswainput')->with('success', 'Data Prestasi Berhasil Dihapus ');
        }
        return redirect('/prestasisiswainput')->with('error', 'Data Prestasi not found!');
    }
}
