<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfilePageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
            $siswa = Auth::guard('siswas')->user();  // ini akan mendapatkan data siswa yang sedang login
       
            // Periksa apakah session 'walas_id' ada
            if (!session()->has('siswa_id')) {
                return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
            }
       
            // Ambil data siswa berdasarkan 'walas_id' yang ada di session
            $siswa = Siswa::find(session('siswa_id'));
            
            // Periksa apakah data siswa ditemukan
            if (!$siswa) {
                return redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.');
            }
       
          return view('profilesiswa.index', compact('siswa'));
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
         $siswa = Auth::guard('siswas')->user();  // ini akan mendapatkan data walas yang sedang login
   
         // Periksa apakah session 'walas_id' ada
         if (!session()->has('siswa_id')) {
             return redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.');
         }
    
         // Ambil data walas berdasarkan 'walas_id' yang ada di session
         $siswa = Siswa::find(session('siswa_id'));
         
         // Periksa apakah data walas ditemukan
         if (!$siswa) {
             return redirect('/loginsiswa')->with('error', 'Data Siswa tidak ditemukan.');
         }

        // Ambil data produk berdasarkan ID
        $siswa = Siswa::findOrFail($id);

        // Kirim data ke view edit
        return view('profilesiswa.edit', compact('siswa'));
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
        $siswa = Siswa::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
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
    
        // Update data Wali Kelas
        $siswa->nama = $request->nama;
        $siswa->no_wa = $request->no_wa;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
            $siswa->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
        $siswa->save();
    
        // Redirect dengan pesan sukses
        return redirect('/profilesiswa')->with('success', 'Data Siswa Berhasil di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
