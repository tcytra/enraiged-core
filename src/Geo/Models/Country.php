<?php

namespace Enraiged\Geo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    /** @var  string  The database table name. */
    protected $table = 'countries';

    /** @var  bool  Indicates if the model should be timestamped. */
    public $timestamps = false;

    /** @var  array  The attributes that aren't mass assignable. */
    protected $guarded = [
        'id',
    ];

    /** @var  array  The attributes that should be cast. */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     *  @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }
}
