<?php

namespace Enraiged\Profiles\Models\Relations;

use Illuminate\Database\Eloquent\Relations\HasOne;

trait HasOneUser
{
    /**
     *  @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        $model = config('auth.providers.users.model');

        return $this->hasOne($model, 'profile_id', 'id')
            ->withTrashed();
    }
}
