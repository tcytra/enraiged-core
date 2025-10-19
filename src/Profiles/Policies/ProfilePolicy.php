<?php

namespace Enraiged\Profiles\Policies;

use Enraiged\Profiles\Models\Profile;
use Enraiged\Users\Models\User;

class ProfilePolicy
{
    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Profiles\Models\Profile  $profile
     *  @return bool
     */
    public function edit(User $auth, Profile $profile)
    {
        return $auth->can('edit', $profile->user);
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Profiles\Models\Profile  $profile
     *  @return bool
     */
    public function update(User $auth, Profile $profile)
    {
        return $auth->can('update', $profile->user);
    }
}
