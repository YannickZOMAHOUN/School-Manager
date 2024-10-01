<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.two_factor_code')
                    ->subject('Votre code de vérification')
                    ->with([
                        'code' => $this->user->two_fa_code,
                        'name' => $this->user->staff->name,
                        'surname' => $this->user->staff->surname,
                    ]);
    }
}
