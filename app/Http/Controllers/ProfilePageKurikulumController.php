<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kurikulum;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfilePageKurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kurikulum = Auth::guard('kurikulums')->user();  // ini akan mendapatkan data walas yang sedang login
   
        // Periksa apakah session 'walas_id' ada
        if (!session()->has('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }
   
        // Ambil data walas berdasarkan 'walas_id' yang ada di session
        $kurikulum = Kurikulum::find(session('kurikulum_id'));
        
        // Periksa apakah data walas ditemukan
        if (!$kurikulum) {
            return redirect('/loginkurikulum')->with('error', 'Data Kurikulum tidak ditemukan.');
        }
   
      return view('profilekurikulum.index', compact('kurikulum'));
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
         $kurikulum = Auth::guard('kurikulums')->user();  // ini akan mendapatkan data walas yang sedang login
   
         // Periksa apakah session 'walas_id' ada
         if (!session()->has('kurikulum_id')) {
             return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
         }
    
         // Ambil data walas berdasarkan 'walas_id' yang ada di session
         $kurikulum = Kurikulum::find(session('kurikulum_id'));
         
         // Periksa apakah data walas ditemukan
         if (!$kurikulum) {
             return redirect('/loginkurikulum')->with('error', 'Data Kurikulum tidak ditemukan.');
         }

        // Ambil data produk berdasarkan ID
        $kurikulum = Kurikulum::findOrFail($id);

        // Kirim data ke view edit
        return view('profilekurikulum.edit', compact('kurikulum'));
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
            'nip' => 'required|numeric',
        ]);
    
        // Cari Wali Kelas berdasarkan ID
        $kurikulum = Kurikulum::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
        // Simpan foto jika ada file baru yang diunggah
        if ($request->hasFile('image_url')) {
            // Hapus foto lama jika ada
            if ($kurikulum->image_url) {
                Storage::delete('public/' . $kurikulum->image_url);
            }
            
            // Simpan foto baru
            $imagePath = $request->file('image_url')->store('kurikulum/Photos', 'public');
            $kurikulum->image_url = $imagePath; // Update dengan path foto yang baru
        }
    
        // Update data Wali Kelas
        $kurikulum->nama = $request->nama;
        $kurikulum->no_wa = $request->no_wa;
        $kurikulum->nip = $request->nip;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
            $kurikulum->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
        $kurikulum->save();
    
        // Redirect dengan pesan sukses
        return redirect('/profilekurikulum')->with('success', 'Data Kurikulum Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
