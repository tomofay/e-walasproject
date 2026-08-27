<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.logingtk'); // Ganti dengan nama view login Anda
    }

    // Memproses login
    public function login(Request $request)
    {
        // Validasi input email dan password
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        // Cek kredensial untuk guard 'walas'
        if (Auth::guard('walas')->attempt($validated)) {
            // Jika login berhasil, redirect ke halaman yang diinginkan
            return redirect()->intended('/walaspage'); // Ganti dengan rute yang diinginkan
        }

        // Jika login gagal, kembali ke form login dengan pesan error
        return redirect()->route('logingtk')->withErrors(['error' => 'Login gagal. Periksa email dan password Anda.']);
    }
}
