<?php

namespace App\Http\Concerns;

use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

trait HasSiswaAuth
{
    protected function getAuthenticatedSiswa(): Siswa
    {
        $siswa = Auth::guard('siswas')->user();

        if (! $siswa && ! session('siswa_id')) {
            abort(redirect('/loginsiswa')->with('error', 'Silakan login terlebih dahulu.'));
        }

        if (! $siswa) {
            $siswa = Siswa::find(session('siswa_id'));
        }

        if (! $siswa) {
            abort(redirect('/loginsiswa')->with('error', 'Data siswa tidak ditemukan.'));
        }

        return $siswa;
    }
}
