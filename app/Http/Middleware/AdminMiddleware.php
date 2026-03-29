<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (session('user_type') !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak. Anda harus login sebagai admin.');
        }

        return $next($request);
    }
}
