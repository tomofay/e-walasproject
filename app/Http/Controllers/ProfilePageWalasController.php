<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;


class ProfilePageWalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
       
           // Ambil data siswa berdasarkan rombel yang terkait dengan walas
           $siswa = DB::table('vwsiswas')
                       ->where('id', $rombel->id)  // Pastikan kolom yang digunakan sesuai dengan relasi rombel
                       ->get();
       
           // Ambil semua data rombels
           $rombels = Rombel::all();
  
          return view('profilewalas.index', compact('walas', 'rombel', 'siswa', 'rombels'));
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
         $walas = Auth::guard('walas')->user();  // ini akan mendapatkan data walas yang sedang login
   
         // Periksa apakah session 'walas_id' ada
         if (!session()->has('walas_id')) {
             return redirect('/loginwalas')->with('error', 'Silakan login terlebih dahulu.');
         }
    
         // Ambil data walas berdasarkan 'walas_id' yang ada di session
         $walas = Walas::find(session('walas_id'));
         
         // Periksa apakah data walas ditemukan
         if (!$walas) {
             return redirect('/loginwalas')->with('error', 'Data Wali Kelas tidak ditemukan.');
         }

        // Ambil data produk berdasarkan ID
        $walas = Walas::findOrFail($id);

        // Kirim data ke view edit
        return view('profilewalas.edit', compact('walas'));
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
        $walas->nip = $request->nip;
    
        // Update password jika diisi (jika tidak, biarkan yang lama)
        if ($request->filled('password')) {
            $walas->password = Hash::make($request->password);
        }
    
        // Simpan perubahan ke database
        $walas->save();
    
        // Redirect dengan pesan sukses
        return redirect('/profilewalas')->with('success', 'Data Walas Berhasil di Edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
