<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembinaSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginPembinaSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('loginpembinasiswa.index');
    }

    /**
     * Store a newly created resource in storage (login).
     */
    public function store(Request $request)
    {
        $loginField = $request->input('nama') ?? $request->input('nip');

        if (!$loginField || !$request->filled('password')) {
            return redirect()->route('loginpembinasiswa.index')->with('error', 'Nama/NIP dan password wajib diisi.');
        }

        $pembina = PembinaSiswa::where('nama', $loginField)
            ->orWhere('nip', $loginField)
            ->first();

        if ($pembina && Hash::check($request->password, $pembina->password)) {
            $request->session()->forget(['walas_id', 'admin_id', 'kakom_id', 'kepsek_id', 'kurikulum_id', 'siswa_id']);
            Auth::guard('walas')->logout();
            Auth::guard('admins')->logout();
            Auth::guard('kakoms')->logout();
            Auth::guard('kepseks')->logout();
            Auth::guard('kurikulums')->logout();
            Auth::guard('siswas')->logout();

            $request->session()->put('pembina_id', $pembina->id);
            $request->session()->put('pembina_nama', $pembina->nama);
            Auth::guard('pembinas')->login($pembina);

            return redirect()->route('pembina.dashboard')->with('success', 'Login berhasil! Selamat datang, ' . $pembina->nama . '.');
        }

        return redirect()->route('loginpembinasiswa.index')->with('error', 'Login gagal! Nama/NIP atau password salah.');
    }

    /**
     * Logout session.
     */
    public function logout(Request $request)
    {
        Auth::guard('pembinas')->logout();
        $request->session()->forget(['pembina_id', 'pembina_nama']);
        $request->session()->flash('status', 'Logout Berhasil');
        return redirect('/');
    }
}
