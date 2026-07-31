<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
            $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data siswa yang sedang login
       
            // Periksa apakah session 'walas_id' ada
            if (!session()->has('admin_id')) {
                return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
            }
       
            // Ambil data berdasarkan 'id' yang ada di session
            $admin = Admin::find(session('admin_id'));
            
            // Periksa apakah data siswa ditemukan
            if (!$admin) {
                return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
            }
       
          return view('profileadmin.index', compact('admin'));
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
        //
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
         // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
         $admin = Auth::guard('admins')->user();  // ini akan mendapatkan data walas yang sedang login
   
         // Periksa apakah session 'walas_id' ada
         if (!session()->has('admin_id')) {
             return redirect('/loginadmin')->with('error', 'Silakan login terlebih dahulu.');
         }
    
         // Ambil data walas berdasarkan 'walas_id' yang ada di session
         $admin = Admin::find(session('admin_id'));
         
         // Periksa apakah data walas ditemukan
         if (!$admin) {
             return redirect('/loginadmin')->with('error', 'Data Admin tidak ditemukan.');
         }

        // Ambil data produk berdasarkan ID
        $admin = Admin::findOrFail($id);

        // Kirim data ke view edit
        return view('profileadmin.edit', compact('admin'));
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
        $admin = Admin::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
        // Simpan foto jika ada file baru yang diunggah
        if ($request->hasFile('image_url')) {
            // Hapus foto lama jika ada
            if ($admin->image_url) {
                Storage::delete('public/' . $admin->image_url);
            }
            
            // Simpan foto baru
            $imagePath = $request->file('image_url')->store('adminfoto/Photos', 'public');
            $admin->image_url = $imagePath; // Update dengan path foto yang baru
        }
    
        // Update data Wali Kelas
        $admin->nama = $request->nama;
        $admin->no_wa = $request->no_wa;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
        $admin->save();
    
        // Redirect dengan pesan sukses
        return redirect('/profileadmin')->with('success', 'Data Admin Berhasil di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
