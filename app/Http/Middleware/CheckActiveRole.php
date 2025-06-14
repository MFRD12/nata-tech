<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckActiveRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // if (is_array($roles)) {
        //     // Kalau sudah array, langsung gunakan
        //     $rolesArray = $roles;
        // } else {
        //     // Kalau string, split
        //     $rolesArray = preg_split('/[,\|]/', $roles);
        // }

        // Abaikan middleware untuk route yang tidak butuh role aktif
        if ($request->routeIs('view-pilih-role', 'set-active-role', 'reset-active-role')) {
            return $next($request);
        }

        // Menyimpan role dalam bentuk array
        $rolesArray = $roles;

        $activeRole = session('active_role');

        // Cek apakah user punya salah satu role
        if (!Auth::check() || !Auth::user()->hasAnyRole($rolesArray)) {
            return redirect()->back()->with('error', 'Kamu Tidak Punya Akses Ke halaman tersebut.');
        }

        // Cek session active_role harus ada dan termasuk roles yg diizinkan
        if (!$activeRole || !in_array($activeRole, $rolesArray)) {
            return redirect()->back()->with('error', 'Kamu tidak punya akses dengan role saat ini.');
        }

        return $next($request);
    }
}
