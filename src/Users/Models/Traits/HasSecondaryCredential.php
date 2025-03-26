<?php

namespace Enraiged\Users\Models\Traits;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;

trait HasSecondaryCredential
{
    /** @var  bool  Indicate that email notifications should be directed to the secondary address. */
    public static $emailToSecondary = false;

    /**
     *  Determine if the username is an email address.
     *
     *  @return bool
     */
    public function getUsernameIsEmailAddressAttribute(): bool
    {
        return ! is_null($this->username)
            && ! Validator::make(['username' => $this->username], ['username' => 'email'])->fails();
    }

    /**
     *  Route notifications for the mail channel.
     *
     *  @param  \Illuminate\Notifications\Notification  $notification
     *  @return array|string
     */
    public function routeNotificationForMail(Notification $notification): array|string
    {
        if (self::$emailToSecondary && $this->usernameIsEmailAddress) {
            return [$this->username => $this->name];
        }

        return [$this->email => $this->name];
    }
}
