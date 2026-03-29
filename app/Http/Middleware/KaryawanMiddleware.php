<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class KaryawanMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('user_type') !== 'karyawan') {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
