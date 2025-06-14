<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): View
    {
        return view('cms.auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
        'token' => ['required'],
        'nip_or_email' => ['required', 'string'], // validasi lebih longgar, bisa kamu perketat sesuai format NIP
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Cari user berdasarkan nip atau email
    $user = User::where('nip', $request->nip_or_email)
                ->orWhere('email', $request->nip_or_email)
                ->first();

    if (!$user) {
        return back()->withInput($request->only('nip_or_email'))
                     ->withErrors(['nip_or_email' => 'User dengan NIP atau Email tidak ditemukan.']);
    }

    // Gunakan email user untuk proses reset password Laravel
    $status = Password::reset(
        [
            'email' => $user->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'token' => $request->token,
        ],
        function (User $user) use ($request) {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'remember_token' => Str::random(60),
            ])->save();

            event(new PasswordReset($user));
        }
    );

    return $status == Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', 'Password Berhasil dirubah')
                : back()->withInput($request->only('nip_or_email'))
                      ->withErrors(['nip_or_email' => __($status)]);
    }
}
