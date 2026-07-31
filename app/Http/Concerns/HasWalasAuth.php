<?php

namespace App\Http\Concerns;

use App\Models\Walas;
use App\Models\Rombel;
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
}
