<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loginsiswa.index');
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
        $siswa = Siswa::where('nama', $request->nama)->first();

        // Periksa apakah siswa ditemukan dan password cocok
        if ($siswa && Hash::check($request->password, $siswa->password)) {
            $request->session()->put('siswa_id', $siswa->id);
            Auth::guard('siswas')->login($siswa);

            // Redirect ke halaman siswa dengan pesan sukses
            return redirect()->route('homepagesiswa.index')->with('success', 'Login berhasil! Selamat datang di halaman Siswa.');
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
