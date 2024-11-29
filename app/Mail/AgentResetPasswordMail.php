<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Admin;

class AgentResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $agent;
    public $resetLink; 
    public function __construct(Admin $agent)
    {
        $this->agent = $agent;
        $this->resetLink = url('/api/agent/reset-password', $agent->reset_token);
    }

    public function build()
    {
        return $this->view('emails.agent-reset-password')->with([
            'token' => $this->agent->reset_token, // Pass the token variable
        ]);
    }
}
