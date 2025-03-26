<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Users\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail as VerificationContract;

trait MustVerifyEmail
{
    use \Illuminate\Auth\MustVerifyEmail;

    /**
     *  Determine whether this user must verify their email address.
     *
     *  @return bool
     */
    public function getMustVerifyEmailAttribute(): bool
    {
        return $this instanceof VerificationContract
            && ! $this->hasVerifiedEmail();
    }

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
