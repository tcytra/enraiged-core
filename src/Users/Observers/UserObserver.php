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
        }

        if ($user->isDirty('username') && $user->usernameIsEmailAddress) {
            $user->username = strtolower($user->username);
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
