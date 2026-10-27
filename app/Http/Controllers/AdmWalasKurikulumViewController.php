<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Walas;
use App\Models\Kakom;
use App\Models\Kepsek;
use App\Models\Kurikulum;
use App\Models\Rombel;

class AdmWalasKurikulumViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Menggunakan guard 'kurikulums' untuk mendapatkan data kurikulum yang login
        $kurikulums = Auth::guard('kurikulums')->user();  // ini akan mendapatkan data kurikulum yang sedang login
    
        // Periksa apakah session 'kurikulum_id' ada
        if (!session()->has('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'kurikulum_id' yang ada di session
        $kurikulums = Kurikulum::find(session('kurikulum_id'));
        
        // Periksa apakah data kurikulum ditemukan
        if (!$kurikulums) {
            return redirect('/loginkurikulum')->with('error', 'Data Kurikulum tidak ditemukan.');
        }

        $kurikulumIds = Rombel::pluck('walas_id')->toArray();

        $walasList = Walas::whereIn('id', $kurikulumIds)->get();
        $rombels = Rombel::all();

        // Return view dengan data yang difilter
        return view("homepagekurikulum.datawalas", compact('walasList', 'kurikulumIds', 'kurikulums', 'rombels'));
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
    public function show($walas_id)
    {
        // Menggunakan guard 'walas' untuk mendapatkan data walas yang login
        $kurikulums = Auth::guard('kurikulums')->user();  // ini akan mendapatkan data kurikulum yang sedang login
    
        // Periksa apakah session 'kurikulum_id' ada
        if (!session()->has('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }
  
        // Ambil data kurikulum berdasarkan 'kurikulum_id' yang ada di session
        $kurikulum = Kurikulum::find(session('kurikulum_id'));
        $kurikulums = $kurikulum;
        
        // Periksa apakah data kurikulum ditemukan
        if (!$kurikulum) {
            return redirect('/loginkurikulum')->with('error', 'Data Kurikulum tidak ditemukan.');
        }

        // Ambil data walas berdasarkan walas_id
        $walas = Walas::find($walas_id);
    
        // Jika tidak ditemukan, kembalikan ke halaman sebelumnya dengan pesan error
        if (!$walas) {
            return redirect('/kurikulumwalas')->with('error', 'Data Walas tidak ditemukan.');
        }
    
        // Kirim data ke view detail; nama variabel dibuat konsisten agar Blade tidak crash
        return view('homepagekurikulum.admwalasview.admwalas', compact('walas', 'kurikulum', 'kurikulums'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
