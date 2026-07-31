<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Kepsek;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfileKepsekPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
            $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data siswa yang sedang login
       
            // Periksa apakah session 'walas_id' ada
            if (!session()->has('kepsek_id')) {
                return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
            }
       
            // Ambil data siswa berdasarkan 'walas_id' yang ada di session
            $kepsek = Kepsek::find(session('kepsek_id'));
            
            // Periksa apakah data siswa ditemukan
            if (!$kepsek) {
                return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
            }
       
          return view('profilekepsek.index', compact('kepsek'));
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
         $kepsek = Auth::guard('kepseks')->user();  // ini akan mendapatkan data walas yang sedang login
   
         // Periksa apakah session 'walas_id' ada
         if (!session()->has('kepsek_id')) {
             return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
         }
    
         // Ambil data walas berdasarkan 'walas_id' yang ada di session
         $kepsek = Kepsek::find(session('kepsek_id'));
         
         // Periksa apakah data walas ditemukan
         if (!$kepsek) {
             return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
         }

        // Ambil data produk berdasarkan ID
        $kepsek = Kepsek::findOrFail($id);

        // Kirim data ke view edit
        return view('profilekepsek.edit', compact('kepsek'));
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
                Storage::delete('public/' . $kepsek->image_url);
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
        return redirect('/profilekepsek')->with('success', 'Data Siswa Berhasil di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
