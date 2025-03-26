<?php

namespace Enraiged;

use Enraiged\Users\Observers\UserObserver;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Event;
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

        Event::listen(
            \Illuminate\Auth\Events\Failed::class,
            \Enraiged\Users\Listeners\FailedListener::class,
        );

        Event::listen(
            \Illuminate\Auth\Events\Registered::class,
            \Enraiged\Users\Listeners\RegisteredListener::class,
        );

        Event::listen(
            \Illuminate\Auth\Events\Verified::class,
            \Enraiged\Users\Listeners\VerifiedListener::class,
        );

        Relation::morphMap([
            'user' => $model,
        ]);
    }
}
