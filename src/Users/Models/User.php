<?php

namespace Enraiged\Users\Models;

use Enraiged\Database\Tracking;
use Enraiged\Users\Factories\UserFactory;
use Enraiged\Users\Notifications\WelcomeNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Relations\BelongsToProfile,
        Relations\HasNetworkAddresses,
        Relations\HasPasswordHistory,
        Scopes\Active,
        Scopes\Deleted,
        Traits\CanResetPassword,
        Traits\HasContext,
        Traits\HasSecondaryCredential,
        Traits\MustVerifyEmail,
        Traits\MustVerifySecondary,
        HasFactory, Notifiable, SoftDeletes, Tracking;

    /** @var  string  The database table name. */
    protected $table = 'users';

    /**
     *  The attributes that are mass assignable.
     *
     *  @var list<string>
     */
    protected $fillable = [
        'email',
        'locale',
        'name',
        'password',
        'profile_id',
        'theme',
        'username',
    ];

    /**
     *  The attributes that should be hidden for serialization.
     *
     *  @var list<string>
     */
    protected $hidden = [
        'is_hidden',
        'is_protected',
        'password',
        'remember_token',
    ];

    /**
     *  Get the attributes that should be cast.
     *
     *  @return array<string, string>
     */
    #[\Override]
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'is_hidden' => 'boolean',
            'is_protected' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     *  Create a new factory instance for the model.
     *
     *  @return \Illuminate\Database\Eloquent\Factories\Factory
     *  @static
     */
    protected static function newFactory()
    {
        return new UserFactory;
    }

    /**
     *  Return the notification channels for this user.
     *
     *  @return array<string>
     */
    public function notificationChannels()
    {
        return ['mail'];
    }

    /**
     *  Send the welcome notification.
     *
     *  @return void
     */
    public function sendWelcomeNotification()
    {
        if (config('enraiged.auth.send_welcome_notification') === true) {
            $this->notify(
                (new WelcomeNotification)->locale($this->locale)
            );
        }
    }
}
