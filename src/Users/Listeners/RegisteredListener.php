<?php

namespace Enraiged\Users\Listeners;

use Illuminate\Auth\Events\Registered;

class RegisteredListener
{
    /**
     *  Handle the user registered event.
     *
     *  @return void
     */
    public function handle(Registered $event): void
    {
        //  we will trigger a secondary email verification notification here, if applicable
        if (config('enraiged.auth.must_verify_secondary') === true && $event->user->usernameIsEmailAddress) {
            $event->user->sendSecondaryVerificationNotification();
        }

        //  we will trigger a welcome notification here if the system *does not* require email verification
        if (config('enraiged.auth.must_verify_email') !== true) {
            $event->user->sendWelcomeNotification();
        }
    }
}
