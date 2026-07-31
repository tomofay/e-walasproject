<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kakom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginKaprogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loginkaprog.index');
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
        $kaprog = Kakom::where('nama', $request->nama)->first();

        // Periksa apakah kaprog ditemukan dan password cocok
        if ($kaprog && Hash::check($request->password, $kaprog->password)) {
            $request->session()->put('kakom_id', $kaprog->id);
            Auth::guard('kakoms')->login($kaprog);

            // Redirect ke halaman kaprog dengan pesan sukses
            return redirect()->route('homepagekaprog.index')->with('success', 'Login berhasil! Selamat datang di halaman kepala program.');
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
