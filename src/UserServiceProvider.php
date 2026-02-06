<?php

namespace Enraiged;

use Enraiged\Geo\Models\Address;
use Enraiged\Geo\Observers\AddressObserver;
use Enraiged\Profiles\Models\Profile;
use Enraiged\Profiles\Observers\ProfileObserver;
use Enraiged\Profiles\Policies\ProfilePolicy;
use Enraiged\Users\Models\User;
use Enraiged\Users\Models\VerifiedUser;
use Enraiged\Users\Observers\UserObserver;
use Enraiged\Users\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class UserServiceProvider extends ServiceProvider
{
    /** @var  array  The policy mappings for the enraiged avatars. */
    protected $policies = [
        Profile::class => ProfilePolicy::class,
        User::class => UserPolicy::class,
        VerifiedUser::class => UserPolicy::class,
    ];

    /**
     *  Bootstrap the event services.
     *
     *  @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $model = config('auth.providers.users.model');

        $model::observe(UserObserver::class);

        Address::observe(AddressObserver::class);

        Profile::observe(ProfileObserver::class);

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

        Event::listen(
            \Enraiged\Network\Events\LoginAddress::class,
            \Enraiged\Users\Listeners\LoginAddressListener::class,
        );

        Relation::morphMap([
            'profile' => Profile::class,
            'user' => $model,
        ]);
    }
}
