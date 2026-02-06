<?php

namespace Enraiged\Geo\Models;

use Enraiged\Database\Track\Created;
use Enraiged\Database\Track\Updated;
use Enraiged\Geo\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use Created, HasFactory, Updated;

    /** @var  string  The morphable name. */
    protected $morphable = 'addressable';

    /** @var  string  The database table name. */
    protected $table = 'addresses';

    /** @var  array  The attributes that aren't mass assignable. */
    protected $fillable = [
        'city',
        'country_id',
        'is_default',
        'notes',
        'postal',
        'region_id',
        'street',
        'suite',
    ];

    /** @var  array  The attributes that should be cast. */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     *  Get the parent avatarable model.
     *
     *  @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function addressable()
    {
        return $this->morphTo();
    }

    /**
     *  @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    /**
     *  @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    /**
     *  Create a new factory instance for the model.
     *
     *  @return \Illuminate\Database\Eloquent\Factories\Factory
     *  @static
     */
    protected static function newFactory()
    {
        return new AddressFactory;
    }
}
