<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Walas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginGtkController extends Controller
{
    protected $redirectTo = '/logingtk';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('logingtk.index');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'password' => 'required',
        ]);

        // Cari admin berdasarkan nama
        $walas = Walas::where('nama', $request->nama)->first();

        // Periksa apakah walas ditemukan dan password cocok
        if ($walas && Hash::check($request->password, $walas->password)) {
            $request->session()->put('walas_id', $walas->id);
            Auth::guard('walas')->login($walas);

            // Redirect ke halaman walas dengan pesan sukses
            return redirect()->route('homepagegtk.index')->with('success', 'Login berhasil! Selamat datang di halaman Walas.');
        }

        // Jika gagal, kembali ke halaman login dengan pesan error
        return redirect()->back()->with('error', 'Login gagal! Nama atau password salah.');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
