<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = auth()->user();

        if (!$user->aktif) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Akun Anda sedang dinonaktifkan. Hubungi Manajer.');
        }

        if (!in_array($user->peran, $roles)) {
            abort(403, 'Akses Ditolak: Peran ' . $user->peran . ' tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}
