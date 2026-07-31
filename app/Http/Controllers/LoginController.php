<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Display the login page.
     */
    public function index()
    {
        return view('loginadmin.index');
    }

    /**
     * Handle the login request.
     */
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama' => 'required',
        'password' => 'required',
    ]);

    // Cari admin berdasarkan nama
    $admin = Admin::where('nama', $request->nama)->first();

    // Periksa apakah admin ditemukan dan password cocok
        if ($admin && Hash::check($request->password, $admin->password)) {
        $request->session()->put('admin_id', $admin->id);
        Auth::guard('admins')->login($admin);

        // Redirect ke halaman admin dengan pesan sukses
        return redirect()->route('homepageadmin.index')->with('success', 'Login berhasil! Selamat datang di halaman admin.');
    }

    // Jika gagal, kembali ke halaman login dengan pesan error
    return redirect()->back()->with('error', 'Login gagal! Nama atau password salah.');
}

    
}
