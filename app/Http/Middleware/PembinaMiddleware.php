<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PembinaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('pembinas')->check() && !session('pembina_id')) {
            return redirect('/loginpembinasiswa')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
