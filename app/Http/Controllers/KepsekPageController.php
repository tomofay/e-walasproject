<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Kepsek;
use App\Models\Admin;
use App\Imports\KepsekImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class KepsekPageController extends Controller
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

        $kepsekdata = Kepsek::all();
        return view('homepageadmin.kepsek.index', compact('kepsekdata', 'admin'));
    }

    public function import(Request $request){
        Excel::import(new KepsekImport, $request->file('file'));
    return redirect('/kepalasekolah');
    }

    public function downloadTemplate()
    {
        $pathToFile = storage_path('app/public/template_kepsek.xlsx'); // Sesuaikan dengan lokasi file template Excel
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
            'image_url' => 'nullable|image|max:5000',
            'no_wa' => 'required|numeric',
            'password' => 'required|string|min:2',
        ]);
    
        // Proses penyimpanan file gambar di folder walasfoto/Photos
        $imagePath = $request->file('image_url')->store('kepsekfoto/Photos', 'public'); // Simpan gambar di folder yang diinginkan
    
        // Simpan data ke database, termasuk path gambar
        Kepsek::create([
            'nama' => $request->nama,
            'no_wa' => $request->no_wa,
            'password' => Hash::make($request->password),
            'image_url' => $imagePath, // Simpan path gambar di database
        ]);
    
        /// Redirect kembali dengan data terbaru
        return redirect()->back()->with([
            'success' => 'Data Kepala Sekolah berhasil ditambahkan!',
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
    public function edit(string $id)
    {
        // Ambil data produk berdasarkan ID
        $kepsek = Kepsek::findOrFail($id);

        // Kirim data ke view edit
        return view('homepageadmin.kepsek.edit', compact('kepsek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'image_url' => 'nullable|image|max:5000', // Foto bersifat opsional
            'no_wa' => 'required|numeric',
            'password' => 'nullable|string|min:1', // Password opsional
        ]);
    
        // Cari Wali Kelas berdasarkan ID
       $kepsek = Kepsek::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
        // Simpan foto jika ada file baru yang diunggah
        if ($request->hasFile('image_url')) {
            // Hapus foto lama jika ada
            if ($kepsek->image_url) {
                Storage::delete('public/' .$kepsek->image_url);
            }
            
            // Simpan foto baru
            $imagePath = $request->file('image_url')->store('kepsekfoto/Photos', 'public');
           $kepsek->image_url = $imagePath; // Update dengan path foto yang baru
        }
    
        // Update data Wali Kelas
       $kepsek->nama = $request->nama;
       $kepsek->no_wa = $request->no_wa;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
           $kepsek->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
       $kepsek->save();
    
        // Redirect dengan pesan sukses
        return redirect('/kepalasekolah')->with('success', 'Data Kurikulum Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function hapuskepsek(string $id)
    {
      $kepsek = Kepsek::find($id);
        if ($kepsek) {
          $kepsek->delete();
            return redirect('/kepalasekolah')->with('success', 'Kepala Sekolah data Berhasil Dihapus ');
        }
        return redirect('/kepalasekolah')->with('error', 'kepala sekolah not found!');
    }

    public function kepsek_search(Request $request)
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
       $kepsekQuery = Kepsek::query();
    
        foreach ($keywords as $keyword) {
           $kepsekQuery->where('nama', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('no_wa', 'LIKE', '%' . $keyword . '%');
        }
    
       $kepsekdata =$kepsekQuery->get();
    
        return view('homepageadmin.kepsek.index', compact('kepsekdata', 'admin'));
    }
}
