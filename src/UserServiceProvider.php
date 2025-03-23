<?php

namespace Enraiged;

use Enraiged\Users\Observers\UserObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     *  Bootstrap the event services.
     *
     *  @return void
     */
    public function boot()
    {
        $model = config('auth.providers.users.model');

        $model::observe(UserObserver::class);

        Relation::morphMap([
            'user' => $model,
        ]);
    }
}
