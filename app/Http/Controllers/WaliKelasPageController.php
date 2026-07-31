<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Walas;
use App\Models\Admin;
use App\Imports\WalasImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WaliKelasPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data kurikulum yang sedang login
    
        // Periksa apakah session 'kurikulum_id' ada
        if (!session()->has('admin_id')) {
            return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'admin_id' yang ada di session
        $admin = Admin::find(session('admin_id'));
        
        // Periksa apakah data kurikulum ditemukan
        if (!$admin) {
            return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
        }

        $walasdata = Walas::all();
        return view('homepageadmin.walikelasdata.index', compact('admin', 'walasdata'));

    }

    public function import(Request $request){
        //dd ($request->file('file'));
        Excel::import(new WalasImport, $request->file('file'));
    return redirect('/walas');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_walas.xlsx'); // Sesuaikan dengan lokasi file template Excel
        if (!file_exists($pathToFile)) {
            return back()->with('error', 'Template belum tersedia.');
        }
        return response()->download($pathToFile);
    }
    /**
     * Show the form for creating a new resource.
     */
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
            'jenis_kelamin' => 'required',
            'image_url' => 'nullable|image|max:5000',
            'no_wa' => 'required|numeric',
            'password' => 'required|string|min:2',
            'nip' => 'required|numeric',
        ]);
    
        // Proses penyimpanan file gambar di folder walasfoto/Photos
        $imagePath = $request->file('image_url')->store('walasfoto/Photos', 'public'); // Simpan gambar di folder yang diinginkan
    
        // Simpan data ke database, termasuk path gambar
        Walas::create([
            'nama' => $request->nama,
            'no_wa' => $request->no_wa,
            'jenis_kelamin' => $request->jenis_kelamin,
            'password' => Hash::make($request->password),
            'nip' => $request->nip,
            'image_url' => $imagePath, // Simpan path gambar di database
        ]);
    
        /// Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Wali Kelas berhasil ditambahkan!',
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**e
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Ambil data produk berdasarkan ID
        $walas = Walas::findOrFail($id);

        // Kirim data ke view edit
        return view('homepageadmin.walikelasdata.edit', compact('walas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:5000', // Foto bersifat opsional
        'no_wa' => 'required|numeric',
        'password' => 'nullable|string|min:2', // Password opsional
        'nip' => 'required|numeric',
        'jenis_kelamin' => 'required|string',
    ]);

    // Cari Wali Kelas berdasarkan ID
    $walas = Walas::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404

    // Simpan foto jika ada file baru yang diunggah
    if ($request->hasFile('image_url')) {
        // Hapus foto lama jika ada
        if ($walas->image_url) {
            Storage::delete('public/' . $walas->image_url);
        }
        
        // Simpan foto baru
        $imagePath = $request->file('image_url')->store('walasfoto/Photos', 'public');
        $walas->image_url = $imagePath; // Update dengan path foto yang baru
    }

    // Update data Wali Kelas
    $walas->nama = $request->nama;
    $walas->no_wa = $request->no_wa;
    $walas->jenis_kelamin = $request->jenis_kelamin;
    $walas->nip = $request->nip;

    // Update password jika diisi (jika tidak, biarkan yang lama)
    if ($request->filled('password')) {
        $walas->password = Hash::make($request->password);
    }

    // Simpan perubahan ke database
    $walas->save();

    // Redirect dengan pesan sukses
    return redirect('/walas')->with('success', 'Data Walas Berhasil di Edit');
}


    /**
     * Remove the specified resource from storage.
     */
    public function hapuswalas(string $id)
    {
        $walas = Walas::find($id);
        if ($walas) {
            $walas->delete();
            return redirect('/walas')->with('success', 'Walas data Berhasil Dihapus ');
        }
        return redirect('/walas')->with('error', 'Walas not found!');
    }

    public function walas_search(Request $request)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data kurikulum yang sedang login
    
        // Periksa apakah session 'kurikulum_id' ada
        if (!session()->has('admin_id')) {
            return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'admin_id' yang ada di session
        $admin = Admin::find(session('admin_id'));
        
        // Periksa apakah data kurikulum ditemukan
        if (!$admin) {
            return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
        }

        $search_text = $request->keyword;
        $keywords = explode(' ', $search_text); 
        $walasQuery = Walas::query();
    
        foreach ($keywords as $keyword) {
            $walasQuery->where('nama', 'LIKE', '%' . $keyword . '%');
        }
    
        $walasdata = $walasQuery->get();
    
        return view('homepageadmin.walikelasdata.index', compact('walasdata', 'admin'));
    }

}
