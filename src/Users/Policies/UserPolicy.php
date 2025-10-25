<?php

namespace Enraiged\Users\Policies;

use Enraiged\Users\Models\User;
// use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    // use HandlesAuthorization;

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return bool
     */
    public function create(User $auth)
    {
        return $auth->exists;
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return bool
     */
    public function delete(User $auth, User $user)
    {
        if ($user->isDeleted || $user->isProtected || ($user->isMyself && !$user->allowSelfDelete)) {
            return false;
        }

        return $auth->exists; //$user->isMyself && $user->allowSelfDelete;
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return bool
     */
    public function edit(User $auth, User $user)
    {
        if (!is_null($user->deleted_at) || $user->isProtected) {
            return false;
        }

        return $auth->exists; //$user->isMyself;
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @return bool
     */
    public function export(User $auth)
    {
        return $auth->exists;
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return bool
     */
    public function impersonate(User $auth, User $user)
    {
        return $auth->exists
            && !$user->isMyself
            && !$user->isDeleted
            && !$user->isProtected
            && !session()->has('impersonate');
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @return bool
     */
    public function index(User $auth)
    {
        return $auth->exists;
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return bool
     */
    public function restore(User $auth, User $user)
    {
        return $auth->exists && $user->isDeleted;
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return bool
     */
    public function show(User $auth, User $user)
    {
        return $auth->exists; //$user->isMyself;
    }

    /**
     *  @param  \Enraiged\Users\Models\User  $auth
     *  @param  \Enraiged\Users\Models\User  $user
     *  @return bool
     */
    public function update(User $auth, User $user)
    {
        if (!is_null($user->deleted_at) || $user->isProtected) {
            return false;
        }

        return $auth->exists; //$user->isMyself;
    }
}
