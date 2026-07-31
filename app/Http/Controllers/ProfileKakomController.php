<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kakom;
use App\Models\Rombel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfileKakomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
        {
            // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
            $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data walas yang sedang login
       
            // Periksa apakah session 'walas_id' ada
            if (!session()->has('kakom_id')) {
                return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
            }
       
            // Ambil data walas berdasarkan 'kakom_id' yang ada di session
            $kakom = Kakom::find(session('kakom_id'));
            
            // Periksa apakah data walas ditemukan
            if (!$kakom) {
                return redirect('/loginkaprog')->with('error', 'Data walas tidak ditemukan.');
            }
  
          return view('profilekaprog.index', compact('kakom'));
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
         $kakom = Auth::guard('kakoms')->user();  // ini akan mendapatkan data walas yang sedang login
   
         // Periksa apakah session 'walas_id' ada
         if (!session()->has('kakom_id')) {
             return redirect('/loginkakom')->with('error', 'Silakan login terlebih dahulu.');
         }
    
         // Ambil data walas berdasarkan 'walas_id' yang ada di session
         $kakom = Kakom::find(session('kakom_id'));
         
         // Periksa apakah data walas ditemukan
         if (!$kakom) {
             return redirect('/loginkakom')->with('error', 'Data Kepala Program tidak ditemukan.');
         }

        // Ambil data produk berdasarkan ID
        $kakom = Kakom::findOrFail($id);

        // Kirim data ke view edit
        return view('profilekaprog.edit', compact('kakom'));
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
        $kakom = Kakom::findOrFail($id); // Jika tidak ditemukan, akan mengembalikan error 404
    
        // Simpan foto jika ada file baru yang diunggah
        if ($request->hasFile('image_url')) {
            // Hapus foto lama jika ada
            if ($kakom->image_url) {
                Storage::delete('public/' . $kakom->image_url);
            }
            
            // Simpan foto baru
            $imagePath = $request->file('image_url')->store('kakom/Photos', 'public');
            $kakom->image_url = $imagePath; // Update dengan path foto yang baru
        }
    
        // Update data Wali Kelas
        $kakom->nama = $request->nama;
        $kakom->no_wa = $request->no_wa;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
            $kakom->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
        $kakom->save();
    
        // Redirect dengan pesan sukses
        return redirect('/profilekakom')->with('success', 'Data Kakom Berhasil di Edit');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
