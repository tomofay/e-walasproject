<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class KakomMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('kakoms')->check() && !session('kakom_id')) {
            return redirect('/loginkaprog')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
