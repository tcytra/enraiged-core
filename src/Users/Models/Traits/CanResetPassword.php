<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Users\Notifications\ResetPasswordNotification;

trait CanResetPassword
{
    use \Illuminate\Auth\Passwords\CanResetPassword;

    /**
     *  Send the password reset notification.
     *
     *  @param  string  $token
     *  @return void
     */
    public function sendPasswordResetNotification(#[\SensitiveParameter] $token)
    {
        $this->notify(
            (new ResetPasswordNotification($token))->locale($this->locale)
        );
    }
}
