<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class WalasMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('walas')->check() && !session('walas_id')) {
            return redirect('/logingtk')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
