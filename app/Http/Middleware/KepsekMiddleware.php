<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KepsekMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('kepseks')->check()) {
            return redirect('/loginkepsek')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
