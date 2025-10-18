<?php

namespace Enraiged;

use Enraiged\Profiles\Models\Profile;
use Enraiged\Profiles\Observers\ProfileObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
// use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\ServiceProvider;

class ProfileServiceProvider extends ServiceProvider
{
    /**
     *  Bootstrap the event services.
     *
     *  @return void
     */
    public function boot()
    {
        Profile::observe(ProfileObserver::class);

        Relation::morphMap([
            'profile' => Profile::class,
        ]);
    }
}
