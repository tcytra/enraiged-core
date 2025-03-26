<?php

namespace Enraiged\Users\Models\Traits;

use Enraiged\Users\Notifications\ValidSecondaryLoginFailureNotification;
use Enraiged\Users\Notifications\VerifySecondaryNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail as VerificationContract;

trait MustVerifySecondary
{
    /** @var  bool  Indicate that the secondary email address was just verified. */
    public $wasRecentlySecondaryVerified = false;

    /**
     *  Determine whether this user must verify their email address.
     *
     *  @return bool
     */
    public function getMustVerifySecondaryAttribute(): bool
    {
        return $this instanceof VerificationContract
            && config('enraiged.auth.allow_secondary_credential') === true
            && $this->usernameIsEmailAddress === true
            && ! $this->hasVerifiedSecondary();
    }

    /**
     *  Get the secondary email address that requires verification.
     *
     *  @return string
     */
    public function getSecondaryForVerification()
    {
        return $this->username;
    }

    /**
     *  Determine if the user has verified their email address.
     *
     *  @return bool
     */
    public function hasVerifiedSecondary(): bool
    {
        return ! is_null($this->secondary_verified_at);
    }

    /**
     *  Mark the given user's secondary email as verified.
     *
     *  @return bool
     */
    public function markSecondaryEmailAsVerified()
    {
        $this->wasRecentlySecondaryVerified = true;

        return $this->forceFill([
            'secondary_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     *  Send the secondary email verification notification.
     *
     *  @return void
     */
    public function sendValidSecondaryLoginFailureNotification(): void
    {
        static::$emailToSecondary = true;

        $this->notify(
            (new ValidSecondaryLoginFailureNotification)
                ->locale($this->locale)
        );
    }

    /**
     *  Send the secondary email verification notification.
     *
     *  @return void
     */
    public function sendSecondaryVerificationNotification(): void
    {
        static::$emailToSecondary = true;

        $this->notify(
            (new VerifySecondaryNotification)
                ->locale($this->locale)
        );
    }
}
