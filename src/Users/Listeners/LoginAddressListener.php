<?php

namespace Enraiged\Users\Listeners;

use Enraiged\NetworkAddresses\Events\LoginAddress;

class LoginAddressListener
{
    /**
     *  Handle the user login address event.
     *
     *  @return void
     */
    public function handle(LoginAddress $event): void
    {
        $event->ipAddress->user
            ->sendLoginAddressNotification($event->ipAddress);
    }
}
