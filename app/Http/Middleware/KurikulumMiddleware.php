<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KurikulumMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('kurikulums')->check() && !session('kurikulum_id')) {
            return redirect('/loginkurikulum')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
