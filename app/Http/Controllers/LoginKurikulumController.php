<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kurikulum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginKurikulumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loginkurikulum.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
        $kurikulum = Kurikulum::where('nama', $request->nama)->first();

        // Periksa apakah kurikulum ditemukan dan password cocok
        if ($kurikulum && Hash::check($request->password, $kurikulum->password)) {
            $request->session()->put('kurikulum_id', $kurikulum->id);
            Auth::guard('kurikulums')->login($kurikulum);

            // Redirect ke halaman kurikulum dengan pesan sukses
            return redirect()->route('homepagekurikulum.index')->with('success', 'Login berhasil! Selamat datang di halaman kurikulum.');
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
