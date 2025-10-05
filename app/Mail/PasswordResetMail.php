<?php
// app/Mail/PasswordResetMail.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $name;

    public function __construct($token, $name = null)
    {
        $this->token = $token;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Reset Password - Kode Verifikasi')
                    ->view('emails.password-reset')
                    ->with([
                        'token' => $this->token,
                        'name' => $this->name,
                    ]);
    }
}