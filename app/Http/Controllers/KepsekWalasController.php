<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kepsek;
use App\Models\Walas;
use Illuminate\Support\Facades\Auth;

class KepsekWalasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data Kepala Sekolah yang sedang login
        $kepseks = Auth::guard('kepseks')->user();

        // Periksa apakah sesi 'kepsek_id' ada
        if (!session()->has('kepsek_id')) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil data Kepala Sekolah berdasarkan sesi
        $kepseks = Kepsek::find(session('kepsek_id'));

        // Pastikan data ditemukan
        if (!$kepseks) {
            return redirect('/loginkepsek')->with('error', 'Data Kepala Sekolah tidak ditemukan.');
        }

        // Ambil semua data walas dengan relasi rombelnya
        $walasList = Walas::with('rombel')->get();

        // Kirim data ke view
        return view('homepagekepsek.datawalas', compact('kepseks', 'walasList'));
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
