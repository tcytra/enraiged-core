<?php

namespace Enraiged\Users\Models\Relations;

use Enraiged\Users\Enums\Roles;

trait BelongsToRole
{
    /**
     *  Return the user role.
     *
     *  @return \Enraiged\Users\Enums\Roles
     */
    public function getRoleAttribute()
    {
        $roles = config('auth.providers.roles.enum', Roles::class);

        return $roles::find($this->role_id);
    }
}
