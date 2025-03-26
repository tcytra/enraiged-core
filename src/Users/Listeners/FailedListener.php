<?php

namespace Enraiged\Users\Listeners;

use Illuminate\Auth\Events\Failed;

class FailedListener
{
    /**
     *  Handle the login failed event.
     *
     *  @return void
     */
    public function handle(Failed $event): void
    {
        if (key_exists('attemptSecondary', $event->credentials)
            && config('enraiged.auth.reject_unverified_secondary') === true) {
            //  In this case, a user has attempted a login with a valid but unverified secondary email address
            //  and the login screen has reported failed credentials, so we will send an email to that address
            //  so the user understands why their credentials failed.
            $event->user->sendValidSecondaryLoginFailureNotification();
        }
    }
}
