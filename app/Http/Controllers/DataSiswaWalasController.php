<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Walas;
use App\Models\Rombel;
use App\Imports\SiswaImport;
use App\Models\BiodataSiswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class DataSiswaWalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();  

        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' di session
        $walas = Walas::find(session('walas_id'));
        
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Ambil nama_kelas dari rombel yang dimiliki walas ini
        $rombel = Rombel::where('walas_id', $walas->id)->first();

        if (!$rombel) {
            return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
        }

        // Ambil data siswa yang memiliki nama_kelas yang sama
        $siswa = DB::table('vwsiswas')
            ->leftJoin('keluar_rombels', 'vwsiswas.siswa_id', '=', 'keluar_rombels.nama_siswa')
            ->where('vwsiswas.nama_kelas', $rombel->nama_kelas) // Filter berdasarkan nama_kelas
            ->select('vwsiswas.*', 'keluar_rombels.keterangan')
            ->get();

        // Ambil semua data rombels
        $rombels = Rombel::all();

        // Kirim data ke view
        return view("homepagegtk.siswadata", compact('siswa', 'rombels', 'rombel', 'walas'));
    }

    public function import(Request $request){
        Excel::import(new SiswaImport, $request->file('file'));
    return redirect('/siswadata');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_siswa.xlsx'); // Sesuaikan dengan lokasi file template Excel
        if (!file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }
        return response()->download($pathToFile);
    }

    public function biodata($id)
{
    // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
    $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

    // Periksa apakah session 'walas_id' ada
    if (!session()->has('walas_id')) {
        return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
    }

    // Ambil data walas berdasarkan 'walas_id' yang ada di session
    $walas = Walas::find(session('walas_id'));
    
    // Periksa apakah data walas ditemukan
    if (!$walas) {
        return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
    }

    // Ambil data rombel yang dimiliki walas yang sedang login
    $rombel = Rombel::where('walas_id', $walas->id)->first();

    // Periksa apakah rombel ditemukan
    if (!$rombel) {
        return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
    }

    // Ambil data siswa berdasarkan ID
    $siswa = Siswa::find($id); // Jika data siswa tidak ditemukan, return 404
    if (is_null($siswa)) {
        return back()->with('error', 'Siswa tidak ditemukan');
    }

    $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->get();

    // Cek jika biodata siswa tidak ditemukan
    if ($biodatas->isEmpty()) {
        return back()->with('error', 'Data Biodata Siswa Tidak Ditemukan');
    }

    foreach ($biodatas as $item) {
        $item->fotorumah_base64 = $this->convertToBase64($item->fotorumah_url);
    }

    if (request()->has('export') && request()->get('export') === 'pdf') {
        $biodatas = BiodataSiswa::where('siswas_id', $siswa->id)->first(); // Ambil satu data
        $biodatas->fotorumah_base64 = $this->convertToBase64($biodatas->fotorumah_url);
    
        $pdf = Pdf::loadView('pdf.pdfbiodatasiswa', compact('siswa', 'biodatas', 'walas', 'rombel'));
        return $pdf->stream('Biodata_Siswa.pdf');
    }
    

    // Kembalikan halaman dengan data siswa dan biodata
    return view('homepagegtk.biodatasiswa', compact('siswa', 'biodatas', 'walas', 'rombel'));
}


    private function convertToBase64($path)
    {
        $fullPath = storage_path("app/public/" . $path);
        
        if (file_exists($fullPath)) {
            $imageData = file_get_contents($fullPath);
            $mimeType = mime_content_type($fullPath);
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        }

        return null;
    }

    public function editbiodata($id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));
        
        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Ambil data biodata siswa berdasarkan ID yang dipilih
        $biodata = BiodataSiswa::find($id);
        if (!$biodata) {
            return redirect('/siswadata')->with('error', 'Biodata siswa tidak ditemukan.');
        }

        // Ambil data siswa berdasarkan biodata
        $siswa = Siswa::find($biodata->siswas_id);
        if (!$siswa) {
            return redirect('/siswadata')->with('error', 'Data siswa tidak ditemukan.');
        }

        // Ambil wali kelas dari rombel siswa
        $nowalas = $siswa->rombel ? $siswa->rombel->walas : null;

        // Ambil daftar semua walas
        $walasList = Walas::select('id', 'nama')->get();

        // Ambil nomor WhatsApp walas yang bertanggung jawab
        $walasData = Walas::find($biodata->walas_id);
        $no_wa_walas = $walasData->no_wa ?? 'Nomor tidak tersedia';

        // Tampilkan halaman edit biodata dengan data yang dibutuhkan
        return view('homepagegtk.editbiodata', compact('biodata', 'siswa', 'nowalas', 'walasList', 'no_wa_walas', 'walas'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function updatebiodata(Request $request, $id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user();
        
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));

        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }

        // Ambil data DaftarPesertaDidik yang akan diedit
        $biodata = BiodataSiswa::findOrFail($id);
        
            // Validasi input request
            $request->validate([
                'walas_id' => 'nullable|integer',
                'siswas_id' => 'nullable|integer',
                'nama_lengkap' => 'nullable|string|max:255',
                'jenis_kelamin' => 'nullable|string|max:10',
                'tempat_lahir' => 'nullable|string|max:255',
                'tanggal_lahir' => 'nullable|date',
                'alamat' => 'nullable|string|max:255',
                'alamat_maps' => 'nullable|string|max:5000',
                'fotorumah_url' => 'nullable',
                'jalur_masuk' => 'nullable|string|max:50',
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
                'namasekolah_asal' => 'nullable|string|max:255',
                'alamat_sekolah' => 'nullable|string|max:255',
                'tahun_lulus' => 'nullable|string|max:4',
                'riwayat_penyakit' => 'nullable|string|max:255',
                'alergi' => 'nullable|string|max:255',
                'prestasi_akademik' => 'nullable|string|max:255',
                'prestasi_non_akademik' => 'nullable|string|max:255',
                'pengalaman_ekskul' => 'nullable|string|max:255',
                'kepribadian' => 'nullable|string|max:255'
            ]);

            // Mengecek apakah pekerjaan ayah adalah "Lainnya" dan mengganti nilainya jika perlu
        if ($request->pekerjaan_ayah === 'Lainnya' && $request->has('pekerjaan_ayah_lainnya')) {
            $request->merge(['pekerjaan_ayah' => $request->pekerjaan_ayah_lainnya]);
        }

        // Mengecek apakah pekerjaan ibu adalah "Lainnya" dan mengganti nilainya jika perlu
        if ($request->pekerjaan_ibu === 'Lainnya' && $request->has('pekerjaan_ibu_lainnya')) {
            $request->merge(['pekerjaan_ibu' => $request->pekerjaan_ibu_lainnya]);
        }

        // Periksa apakah ada file baru yang diunggah
        if ($request->hasFile('fotorumah_url')) {
            // Hapus file lama jika ada
            if ($biodata->fotorumah_url && Storage::exists('public/' . $biodata->fotorumah_url)) {
                Storage::delete('public/' . $biodata->fotorumah_url);
            }
            // Simpan file baru
            $fotoRumahPath = $request->file('fotorumah_url')->store('images/photos', 'public');
        } else {
            $fotoRumahPath = $biodata->fotorumah_url; // Gunakan file lama jika tidak ada perubahan
        }


        // Update data siswa
        $biodata->fill($request->all());
        $biodata->siswas_id = $biodata->siswas_id;
        $biodata->nama_lengkap = $request->nama_lengkap;
        $biodata->jenis_kelamin = $request->jenis_kelamin;
        $biodata->tempat_lahir = $request->tempat_lahir;
        $biodata->tanggal_lahir = $request->tanggal_lahir;
        $biodata->alamat = $request->alamat;
        $biodata->alamat_maps = $request->alamat_maps;
        $biodata->fotorumah_url = $fotoRumahPath;
        $biodata->jalur_masuk = $request->jalur_masuk;
        $biodata->jarak_rumah = $request->jarak_rumah;
        $biodata->transportasi_sekolah = $request->transportasi_sekolah;
        $biodata->transportasi_rumah = $request->transportasi_rumah;
        $biodata->agama = $request->agama;
        $biodata->kewarganegaraan = $request->kewarganegaraan;
        $biodata->anak_ke = $request->anak_ke;
        $biodata->jumlah_saudara = $request->jumlah_saudara;
        $biodata->no_wa = $request->no_wa;
        $biodata->email = $request->email;
        $biodata->nis = $request->nis;
        $biodata->nisn = $request->nisn;
        $biodata->kelas = $request->kelas;
        $biodata->kompetensi = $request->kompetensi;
        $biodata->tahun_masuk = $request->tahun_masuk;
        $biodata->nama_ayah = $request->nama_ayah;
        $biodata->pekerjaan_ayah = $request->pekerjaan_ayah;
        $biodata->tempat_lahir_ayah = $request->tempat_lahir_ayah;
        $biodata->tanggal_lahir_ayah = $request->tanggal_lahir_ayah;
        $biodata->alamat_ayah = $request->alamat_ayah;
        $biodata->no_wa_ayah = $request->no_wa_ayah;
        $biodata->nama_ibu = $request->nama_ibu;
        $biodata->pekerjaan_ibu = $request->pekerjaan_ibu;
        $biodata->tempat_lahir_ibu = $request->tempat_lahir_ibu;
        $biodata->tanggal_lahir_ibu = $request->tanggal_lahir_ibu;
        $biodata->alamat_ibu = $request->alamat_ibu;
        $biodata->no_wa_ibu = $request->no_wa_ibu;
        $biodata->namasekolah_asal = $request->namasekolah_asal;
        $biodata->alamat_sekolah = $request->alamat_sekolah;
        $biodata->tahun_lulus = $request->tahun_lulus;
        $biodata->riwayat_penyakit = $request->riwayat_penyakit;
        $biodata->alergi = $request->alergi;
        $biodata->prestasi_akademik = $request->prestasi_akademik;
        $biodata->prestasi_non_akademik = $request->prestasi_non_akademik;
        $biodata->pengalaman_ekskul = $request->pengalaman_ekskul;
        $biodata->kepribadian = $request->kepribadian;

        // Simpan data yang telah diubah
        $biodata->save();

        // Redirect ke halaman dengan pesan sukses
        return redirect('/siswadata')->with([
            'success' => 'Data Diri Siswa berhasil diperbarui!',
            'biodatas' => BiodataSiswa::all(),
            'walas' => DB::table('walas')->select('id', 'nama')->get()
        ]);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'rombels_id' => 'required',
            'jenis_kelamin' => 'required',
            'no_wa' => 'required|numeric',
            'image_url' => 'nullable|image|max:5000',
            'password' => 'required|string|min:2',
            'status' => 'required',
        ]);
    
        // Proses penyimpanan file gambar di folder walasfoto/Photos
        $imagePath = $request->file('image_url')->store('siswafoto/Photos', 'public'); // Simpan gambar di folder yang diinginkan
    
        // Simpan data ke database, termasuk path gambar
        Siswa::create([
            'nama' => $request->nama,
            'rombels_id' => $request->rombels_id,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_wa' => $request->no_wa,
            'password' => Hash::make($request->password),
            'status' => $request->status,
            'image_url' => $imagePath, // Simpan path gambar di database
        ]);
    
        /// Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Siswa berhasil ditambahkan!',
        ]);
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
   // Ambil data produk berdasarkan ID
    $siswa = DB::table('vwsiswas')->where('siswa_id', $id)->first();
    $rombels = Rombel::all(); // Ambil semua data rombel

    // Kirim data ke view edit
    return view('homepagegtk.editsiswa', compact('siswa', 'rombels'));
}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'rombels_id' => 'required',
            'jenis_kelamin' => 'required',
            'no_wa' => 'required|numeric',
            'image_url' => 'nullable|image|max:5000',
            'password' => 'required|string|min:2',
            'status' => 'required',
        ]);
    
        $siswa = Siswa::findOrFail($id); // Mengambil data dari tabel asli

        // Simpan foto jika ada file baru yang diunggah
        if ($request->hasFile('image_url')) {
            // Hapus foto lama jika ada
            if ($siswa->image_url) {
                Storage::delete('public/' . $siswa->image_url);
            }
            
            // Simpan foto baru
            $imagePath = $request->file('image_url')->store('siswafoto/Photos', 'public');
            $siswa->image_url = $imagePath; // Update dengan path foto yang baru
        }
    
        // Update data Siswa
        $siswa->nama = $request->nama;
        $siswa->rombels_id = $request->rombels_id;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->no_wa = $request->no_wa;
        $siswa->status = $request->status;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
        $siswa->save();
    
        // Redirect dengan pesan sukses
        return redirect('/siswadata')->with('success', 'Data siswa Berhasil di Edit');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function hapussiswa(string $id)
    {
        $siswa = Siswa::find($id);
        if ($siswa) {
            $siswa->delete();
            return redirect('/siswadata')->with('success', 'siswa data Berhasil Dihapus ');
        }
        return redirect('/siswadata')->with('error', 'siswa not found!');
    }

    public function siswadata_search(Request $request)
    {
        $search_text = $request->keyword;
        $keywords = explode(' ', $search_text); 
        $siswaQuery = Siswa::query();
    
        // Tambahkan pencarian berdasarkan nama siswa
        foreach ($keywords as $keyword) {
            $siswaQuery->where('nama', 'LIKE', '%' . $keyword . '%');
        }
    
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $walas = Auth::guard('walas')->user(); // ini akan mendapatkan data walas yang sedang login
    
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }
    
        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $walas = Walas::find(session('walas_id'));
        
        // Periksa apakah data walas ditemukan
        if (!$walas) {
            return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
        }
    
        // Ambil data rombel yang dimiliki walas yang sedang login
        $rombel = Rombel::where('walas_id', $walas->id)->first();
    
        // Periksa apakah rombel ditemukan
        if (!$rombel) {
            return redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.');
        }
    
        // Ambil data siswa berdasarkan rombel yang terkait dengan walas
        // Pastikan query hanya mengembalikan siswa yang ada di rombel tersebut
        $siswa = DB::table('vwsiswas')
                    ->where('id', $rombel->id) // Sesuaikan dengan relasi kolom rombel_id
                    ->where(function ($query) use ($keywords) {
                        foreach ($keywords as $keyword) {
                            $query->where('siswa_nama', 'LIKE', '%' . $keyword . '%');
                        }
                    })
                    ->get();
    
        // Ambil data rombel untuk ditampilkan di view (opsional)
        $rombels = Rombel::all();
    
        // Kirim data siswa hasil pencarian dan data lainnya ke view
        return view('homepagegtk.siswadata', compact( 'walas', 'rombels', 'rombel', 'siswa'));
    }

    public function saveKeterangan(Request $request)
    {
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
     $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login

     // Periksa apakah session 'walas_id' ada
     if (!session()->has('walas_id')) {
         return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
     }

     // Ambil data walas berdasarkan 'walas_id' yang ada di session
     $walas = Walas::find(session('walas_id'));
     
     // Periksa apakah data walas ditemukan
     if (!$walas) {
         return redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.');
     }

    // Ambil rombel berdasarkan walas yang sedang login
        $rombel = Rombel::where('walas_id', $walas->id)->first();

        if (!$rombel) {
            return response()->json(['error' => 'Rombel tidak ditemukan untuk walas ini.'], 404);
        }

        // Validasi input
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'keterangan' => 'required|in:naik_kelas,tidak_naik_kelas,pindah_sekolah',
        ]);

        // Ambil nama siswa berdasarkan siswa_id yang dipilih
        $siswa = Siswa::find($request->siswa_id);

        // Buat data baru untuk KeluarRombel
        $keluarRombel = KeluarRombel::create([
            'nama_siswa' => $siswa->id,
            'keterangan' => $request->keterangan,
            'rombels_id' => $rombel->id, // Rombel diambil dari data rombel yang sesuai
        ]);

        return response()->json(['success' => 'Data berhasil disimpan!', 'keluarRombel' => $keluarRombel]);
    }
    
}
