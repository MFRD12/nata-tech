<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('cms.auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nip_or_email' => ['required', 'string'],
        ],[
            'nip_or_email' => 'NIP atau Email wajib diisi'
        ]);

        $nipOrEmail = $request->input('nip_or_email');

        // Cek apakah input formatnya email atau NIP
        if (filter_var($nipOrEmail, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $nipOrEmail)->first();
            if (!$user) {
                return back()->withErrors(['nip_or_email' => 'Data Email tidak ditemukan.'])->withInput();
            }
            // input email
            $email = $nipOrEmail;
        } else {
            // input NIP, cari email user berdasarkan NIP
            $user = User::where('nip', $nipOrEmail)->first();
            if (!$user) {
                return back()->withErrors(['nip_or_email' => 'Data NIP tidak ditemukan.'])->withInput();
            }
            $email = $user->email;
        }
                 
        // Kirim link reset password ke email yang didapat
        $status = Password::sendResetLink(['email' => $email]);

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', 'Link reset password berhasil dikirim. Silakan cek email Anda')
            : back()->withInput($request->only('nip_or_email'))
                ->withErrors(['nip_or_email' => __($status)]);
    }
}
