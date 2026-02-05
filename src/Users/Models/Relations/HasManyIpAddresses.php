<?php

namespace Enraiged\Users\Models\Relations;

use Enraiged\Network\Events\LoginAddress;
use Enraiged\Network\Models\IpAddress;
use Enraiged\Users\Notifications\LoginAddressNotification;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasManyIpAddresses
{
    /**
     *  @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ipAddresses(): HasMany
    {
        return $this->hasMany(IpAddress::class, 'user_id');
    }

    /**
     *  Determine whether the user has any current address history.
     *
     *  @return bool
     */
    public function hasIpAddressHistory(): bool
    {
        return $this->ipAddresses()->count();
    }

    /**
     *  Determine whether the user address history has a specific address.
     *
     *  @param  string  $ip
     *  @return bool
     */
    public function historyHasIpAddress(string $ip): bool
    {
        return $this->ipAddresses()
            ->where('ip_address', inet_pton($ip))
            ->exists();
    }

    /**
     *  Send the new login address notification.
     *
     *  @param  \Enraiged\Network\Models\IpAddress  $ipAddress
     *  @return void
     */
    public function sendLoginAddressNotification(IpAddress $ipAddress)
    {
        if (config('enraiged.auth.send_login_address_notification') === true) {
            $this->notify(
                (new LoginAddressNotification($ipAddress))
                    ->locale($this->locale)
            );
        }
    }

    /**
     *  Create or update an ip address record for the authenticated user.
     *
     *  @param  string  $ip
     *  @return void
     */
    public function trackIpAddress($ip): void
    {
        $credential = session()->get('secondaryLogin') === true
            ? $this->username
            : $this->email;

        $verified = session()->get('secondaryLogin') === true
            ? $this->hasVerifiedSecondary()
            : $this->hasVerifiedEmail();

        $address_search = $this->ipAddresses()
            ->where('ip_address', inet_pton($ip))
            ->where('credential', $credential);

        if ($address_search->exists()) {
            $address_search->first()
                ->increment('increment', 1, ['is_verified' => $verified]);

        } else {
            $eventTrigger = $this->hasIpAddressHistory() 
                && ! $this->historyHasIpAddress($ip);

            $ipAddress = $this->ipAddresses()
                ->create([
                    'credential' => $credential,
                    'ip_address' => $ip,
                    'is_verified' => $verified,
                ]);

            if ($eventTrigger) {
                event(new LoginAddress($ipAddress));
            }
        }
    }
}
