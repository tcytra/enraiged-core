<?php

namespace Enraiged\Network\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class IpAddress extends Model
{
    use Relations\BelongsToUser;

    /** @var  string|null  The name of the "deleted at" column.*/
    const DELETED_AT = null;

    /** @var  string  The database table name. */
    protected $table = 'ip_addresses';

    /**
     *  Get the attributes that should be cast.
     *
     *  @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
        ];
    }

    /** @var  array<string>  The attributes that are mass assignable. */
    protected $fillable = [
        'credential',
        'ip_address',
        'is_verified',
        'user_id',
        'verified_at',
    ];

    /**
     *  Convert the user ip_address from binary to a human readable format.
     *
     *  @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function ipAddress(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => inet_ntop($value),
            set: fn ($value) => inet_pton($value),
        );
    }

    /**
     *  Return the ip_address.
     *
     *  @return string
     */
    public function ip()
    {
        return $this->ip_address;
    }

    /**
     *  Detect and return the version of the ip address.
     *
     *  @return int
     */
    public function version()
    {
        if (filter_var($this->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return 4;
        }

        if (filter_var($this->ip(), FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return 6;
        }

        return 0; // this should never happen
    }
}
