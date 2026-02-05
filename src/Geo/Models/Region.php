<?php

namespace Enraiged\Geo\Models;

use Enraiged\Geo\Models\Country;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Region extends Model
{
    /** @var  string  The database table name. */
    protected $table = 'regions';

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
     *  @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
