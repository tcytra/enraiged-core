<?php

namespace Enraiged\Profiles\Models;

use Enraiged\Avatars\Contracts\AvatarableContract;
use Enraiged\Avatars\Traits\Avatarable;
use Enraiged\Database\Tracking;
use Enraiged\Profiles\Factories\ProfileFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model implements AvatarableContract
{
    use Attributes\Initials,
        Attributes\Name,
        Relations\HasOneUser,
        Avatarable, HasFactory, SoftDeletes, Tracking;

    /** @var  string  The database table name. */
    protected $table = 'profiles';

    /**
     *  Get the fillable attributes for the model.
     *
     *  @return array<string>
     */
    public function getFillable()
    {
        return [
            'alias',
            'birthdate',
            'first_name',
            'last_name',
            'phone',
            'gender',
            'salut',
            'title',
        ];
    }

    /**
     *  Create a new factory instance for the model.
     *
     *  @return \Illuminate\Database\Eloquent\Factories\Factory
     *  @static
     */
    protected static function newFactory()
    {
        return new ProfileFactory;
    }
}
