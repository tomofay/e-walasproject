<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kepsek;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginKepsekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loginkepsek.index');
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
        'nama' => 'required',
        'password' => 'required',
    ]);

    // Cari admin berdasarkan nama
    $kepsek = Kepsek::where('nama', $request->nama)->first();

    // Periksa apakah kepsek ditemukan dan password cocok
        if ($kepsek && Hash::check($request->password, $kepsek->password)) {
            $request->session()->put('kepsek_id', $kepsek->id);
            Auth::guard('kepseks')->login($kepsek);

        // Redirect ke halaman kepsek dengan pesan sukses
        return redirect()->route('homepagekepsek.index')->with('success', 'Login berhasil! Selamat datang di halaman kepala sekolah.');
    }

    // Jika gagal, kembali ke halaman login dengan pesan error
    return redirect()->back()->with('error', 'Login gagal! Nama atau password salah.');
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
