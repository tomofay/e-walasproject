<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kurikulum;
use App\Models\Walas;
use Illuminate\Support\Facades\Auth;

class KurikulumWalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data Kepala Sekolah yang sedang login
        $kurikulums = Auth::guard('kurikulums')->user();

        // Periksa apakah sesi 'kurikulum_id' ada
        if (!session()->has('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data Kepala Sekolah berdasarkan sesi
        $kurikulums = Kurikulum::find(session('kurikulum_id'));

        // Pastikan data ditemukan
        if (!$kurikulums) {
            return redirect('/loginkurikulum')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua data walas dengan relasi rombelnya
        $walasList = Walas::with('rombel')->get();

        // Kirim data ke view
        return view('homepagekurikulum.datawalas', compact('kurikulums', 'walasList'));
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
