<?php

namespace Enraiged\Users\Listeners;

use Illuminate\Auth\Events\Verified;

class VerifiedListener
{
    /**
     *  Handle the user verified event.
     *
     *  @return void
     */
    public function handle(Verified $event): void
    {
        //  we will trigger a welcome notification here if the system *does* require email verification
        if (config('enraiged.auth.must_verify_email') === true && $event->user->wasRecentlySecondaryVerified) {
            $event->user->sendWelcomeNotification();
        }
    }
}
