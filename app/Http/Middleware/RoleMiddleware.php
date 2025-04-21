<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika user belum login, arahkan ke halaman login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Ambil level user yang sedang login
        $user = Auth::user();

        // Periksa apakah level user termasuk dalam roles yang diizinkan
        if (empty($roles) || !in_array($user->level, $roles)) {
            // Redirect berdasarkan role user yang sebenarnya
            switch ($user->level) {
                case 'admin':
                    return redirect('/admin')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
                case 'pemilik':
                    return redirect('/pemilik')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
                case 'bendahara':
                    return redirect('/bendahara')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
                case 'pelanggan':
                    return redirect('/pelanggan')->with('error', 'Anda tidak memiliki akses ke halaman ini.');

            }
        }

        return $next($request);
    }
}
