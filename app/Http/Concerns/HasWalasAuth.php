<?php

namespace App\Http\Concerns;

use App\Models\Walas;
use App\Models\Rombel;
use App\Models\Siswa;
use Illuminate\Support\Facades\Auth;

trait HasWalasAuth
{
    protected function getAuthenticatedWalas(): Walas
    {
        $walas = Auth::guard('walas')->user();

        if (! $walas && ! session('walas_id')) {
            abort(redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.'));
        }

        if (! $walas) {
            $walas = Walas::find(session('walas_id'));
        }

        if (! $walas) {
            abort(redirect('/logingtk')->with('error', 'Data walas tidak ditemukan.'));
        }

        return $walas;
    }

    protected function getWalasRombel(): Rombel
    {
        $walas = $this->getAuthenticatedWalas();
        $rombel = $walas->load('rombel')->rombel;

        if (! $rombel) {
            abort(redirect('/walaspage')->with('error', 'Rombel tidak ditemukan untuk walas ini.'));
        }

        return $rombel;
    }

    /**
     * Resolve a Siswa that belongs to the authenticated Walas' rombel.
     * Prevents IDOR: a Walas may only manage students in their own class.
     */
    protected function siswaDiRombel(string $id): Siswa
    {
        $rombel = $this->getWalasRombel();

        $siswa = Siswa::find($id);

        abort_if(
            ! $siswa || $siswa->rombels_id != $rombel->id,
            403,
            'Siswa tidak berada di rombel Anda.'
        );

        return $siswa;
    }
}
