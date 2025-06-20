<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('cms.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $user = Auth::user();

        // Cek apakah user punya data pegawai dan status tidak aktif
        if ($user->pegawai && $user->pegawai->status === 'tidak aktif') {
            // Hapus session lebih dulu
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Auth::logout(); // Logout setelah session dihapus

            return redirect()->back()->withErrors([
                'nip_or_email' => 'Akun Anda tidak aktif, Silakan hubungi admin.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('view-pilih-role');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

         $request->session()->forget('active_role');

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
