<?php

namespace Enraiged\Users\Observers;

use Enraiged\Users\Models\User;
use Enraiged\Users\Notifications\LoginChangeNotification;

class UserObserver
{
    /**
     *  Handle the User saving event.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return void
     */
    public function saving(User $user)
    {
        if (is_null($user->locale)) {
            $user->locale = config('app.locale');
        }

        if ($user->isDirty('email')) {
            $user->email = strtolower($user->email);
            $user->email_verified_at = null;
        }

        if ($user->isDirty('theme') && gettype($user->theme) === 'array') {
            $user->theme = json_encode($user->theme);
        }

        if ($user->isDirty('username') && $user->usernameIsEmailAddress) {
            $user->username = strtolower($user->username);
            $user->secondary_verified_at = null;
        }

        if (is_null($user->theme)) {
            $user->theme = json_encode(config('enraiged.theme'));
        }
    }

    /**
     *  Handle the User updated event.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return void
     */
    public function updated(User $user)
    {
        $changed = collect($user->getChanges())
            ->only(['email', 'username', 'password']);

        if ($changed->count()) {
            if (config('enraiged.auth.send_login_change_notification') === true) {
                $user->notify(
                    (new LoginChangeNotification)
                        ->locale($user->locale)
                );
            }

            if ($changed->keys()->contains('email')
                    && config('enraiged.auth.must_verify_email') === true) {
                $user->sendEmailVerificationNotification()();
            }

            if ($changed->keys()->contains('username') && $user->usernameIsEmailAddress
                    && config('enraiged.auth.must_verify_secondary') === true) {
                $user->sendSecondaryVerificationNotification();
            }
        }
    }

    /**
     *  Handle the User updating event.
     *
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return void
     */
    public function updating(User $user)
    {
        if (config('enraiged.passwords.history') !== false && $user->isDirty('password')) {
            $user->passwordHistory()
                ->create(['password' => $user->getOriginal('password')]);
        }
    }
}
