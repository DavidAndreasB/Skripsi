<?php

namespace App\Http;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// Catatan: Nama kelas di sini adalah EnsureUserIsAdmin
class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login
        if (! $request->user()) {
            return redirect()->route('login'); 
        }

        // 2. Cek apakah user adalah Super Admin (role = 1)
        if (! $request->user()->isSuperAdmin()) {
            // Jika tidak, tolak akses dengan response 403 Forbidden
            abort(403, 'Akses Ditolak. Hanya Super Admin yang diizinkan untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}