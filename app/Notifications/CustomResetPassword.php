<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class CustomResetPassword extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        // Tampilan Email custom saat diliahat User
        return (new MailMessage)
        ->subject('Reset Kata Sandi Anda')
        ->view('cms.auth.email-reset-password', [
            'url' => $url,
            'nama' => $notifiable->pegawai->nama ?? 'Sahabat',
        ]);
    }
}
