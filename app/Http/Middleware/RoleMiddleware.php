<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role)
    {
        // ❌ Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('loginRequired', 'Silakan login terlebih dahulu untuk mengakses halaman ini.');
        }

        // ❌ Cek apakah role sesuai
        if (Auth::user()->role !== $role) {
            return redirect()->route('login')->withErrors('Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
