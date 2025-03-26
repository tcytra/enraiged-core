<?php

namespace Enraiged\Users\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class VerifySecondaryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     *  Build the mail representation of the notification.
     *
     *  @param  mixed  $notifiable
     *  @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        $message = (new MailMessage)
            ->subject(__('Verify Secondary Email Address'));

        if (config('enraiged.app.mail_markdown') === true) {
            return $message
                ->markdown('mail.auth.verify-secondary', ['url' => $verificationUrl, 'user' => $notifiable]);
        }

        return $message
            ->greeting(__('Hello :name', ['name' => $notifiable->name]))
            ->line(__('Please click the button below to verify your secondary email address.'))
            ->action(__('Verify Secondary Email Address'), $verificationUrl)
            ->line(__('If you did not create an account, no further action is required.'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return URL::temporarySignedRoute(
            'secondary.verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getSecondaryForVerification()),
            ]
        );
    }
}
