<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- INI KUNCI PERBAIKANNYA
use Symfony\Component\HttpFoundation\Response;

class CekRole
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek Login
        if (!Auth::check()) {
            return redirect('/');
        }

        // 2. Cek Role
        if (Auth::user()->role == $role) {
            return $next($request);
        }

        // 3. Jika Salah Kamar (403 Forbidden)
        return abort(403, 'Anda tidak punya akses ke halaman ini');
    }
}