<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Users\Notifications\VerifyEmailNotification;

trait MustVerifyEmail
{
    use \Illuminate\Auth\MustVerifyEmail;

    /**
     *  Send the email verification notification.
     *
     *  @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(
            (new VerifyEmailNotification)->locale($this->locale)
        );
    }
}
