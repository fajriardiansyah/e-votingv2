<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pengecualian (Bypass) untuk halaman Login dan proses Autentikasi
        // Middleware ini tidak perlu dijalankan saat user mencoba login atau logout.
        if ($request->routeIs('filament.admin.auth.*')) {
            return $next($request);
        }
        
        $user = $request->user();

        // 2. SCENARIO BELUM LOGIN (Sesi habis, tapi mencoba akses dashboard)
        if (! $user) {
            // Arahkan ke halaman login (Guest Redirect)
            // Ini akan memastikan Admin bisa login kembali
            return Redirect::guest(route('filament.admin.auth.login')); 
        }

        // 3. SCENARIO BUKAN ADMIN (Sudah login, tapi is_admin = false)
        if (! $user->is_admin) {
            
            // Lakukan logout dan bersihkan sesi untuk user non-admin yang nyasar
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Arahkan ke halaman utama dengan pesan error
            return redirect('/')
                ->with('error', 'Akses Admin Ditolak. Silakan gunakan akun yang sesuai.');
        }

        // 4. SCENARIO ADMIN SAH
        return $next($request);
    }
}