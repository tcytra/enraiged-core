<?php

namespace Enraiged\Users\Models;

use Enraiged\Users\Factories\VerifiedUserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class VerifiedUser extends User implements MustVerifyEmail
{
    /**
     *  Create a new factory instance for the model.
     *
     *  @return \Illuminate\Database\Eloquent\Factories\Factory
     *  @static
     */
    #[\Override]
    protected static function newFactory()
    {
        return new VerifiedUserFactory;
    }
}
