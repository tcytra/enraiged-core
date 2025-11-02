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
    public function getRoleAttribute(): Roles
    {
        return Roles::find($this->role_id);
    }
}
