<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetLink; 
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->resetLink = url('/api/customer/reset-password', $user->reset_token);
    }

    public function build()
    {
        return $this->view('emails.reset-password')->with([
            'token' => $this->user->reset_token, // Pass the token variable
        ]);
    }
}
