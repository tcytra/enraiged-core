<?php

namespace Enraiged\Users\Models\Traits;

use Illuminate\Support\Facades\Auth;

trait ProvidesContext
{
    /**
     *  @return bool
     */
    public function getAllowSecondaryCredentialAttribute(): bool
    {
        return config('enraiged.auth.allow_secondary_credential') === true;
    }

    /**
     *  @return bool
     */
    public function getAllowSelfDeleteAttribute(): bool
    {
        return $this->isMyself && config('enraiged.auth.allow_self_delete') === true;
    }

    /**
     *  @return bool
     */
    public function getAllowUsernameLoginAttribute(): bool
    {
        return config('enraiged.auth.allow_secondary_credential') === true
            && config('enraiged.auth.allow_username_login') === true;
    }

    /**
     *  @return bool
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->exists
            && $this->attributes['is_active'] === 1;
    }

    /**
     *  @return bool
     */
    public function getIsDeletedAttribute(): bool
    {
        return !is_null($this->deleted_at);
    }

    /**
     *  @return bool
     */
    public function getIsHiddenAttribute(): bool
    {
        return $this->exists
            && $this->attributes['is_hidden'] === 1;
    }

    /**
     *  @return bool
     */
    public function getIsMyselfAttribute(): bool
    {
        return Auth::check()
            && $this->id === Auth::id();
    }

    /**
     *  @return bool
     */
    public function getIsNotMyselfAttribute(): bool
    {
        return !$this->isMyself;
    }

    /**
     *  @return bool
     */
    public function getIsProtectedAttribute(): bool
    {
        return $this->exists
            && $this->attributes['is_protected'] === 1;
    }
}
