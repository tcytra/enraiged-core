<?php

namespace Enraiged\Users\Models\Relations;

use App\Enums\Roles;

trait BelongsToRole
{
    /**
     *  Return the user role.
     *
     *  @return \App\Enums\Roles
     */
    public function getRoleAttribute(): Roles
    {
        return Roles::find($this->role_id);
    }
}
