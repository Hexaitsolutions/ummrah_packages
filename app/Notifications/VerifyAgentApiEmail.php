<?php

namespace App\Notifications;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\URL;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;

class VerifyAgentApiEmail extends VerifyEmailBase

{

    /**

    * Get the verification URL for the given notifiable.

    *

    * @param mixed $notifiable

    * @return string

    */

    protected function verificationUrl($notifiable)

    {
        return URL::temporarySignedRoute('verificationapi.agent.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]);
    }

}