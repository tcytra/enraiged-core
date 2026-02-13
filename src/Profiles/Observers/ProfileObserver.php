<?php

namespace Enraiged\Profiles\Observers;

use Enraiged\Profiles\Models\Profile;

class ProfileObserver
{
    /**
     *  Handle the Profile saving event.
     *
     *  @param  \Enraiged\Profiles\Models\Profile  $profile
     *  @return void
     */
    public function saving(Profile $profile)
    {
        if ($profile->birthdate) {
            $profile->birthdate = date('Y-m-d', strtotime($profile->birthdate));
        }
    }

    /**
     *  Handle the Profile updated event.
     *
     *  @param  \Enraiged\Profiles\Models\Profile  $profile
     *  @return void
     */
    public function updated(Profile $profile)
    {
        if ($profile->isDirty(['first_name', 'last_name'])) {
            $profile->user->name = "{$profile->first_name} {$profile->last_name}";
            $profile->user->save();
        }
    }
}
