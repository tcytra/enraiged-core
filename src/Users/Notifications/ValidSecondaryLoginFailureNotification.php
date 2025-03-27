<?php

namespace Enraiged\Users\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ValidSecondaryLoginFailureNotification extends Notification implements ShouldQueue
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
        $message = (new MailMessage)
            ->subject(__('Secondary Login Failed'));

        if (config('enraiged.app.mail_markdown') === true) {
            return $message
                ->markdown('mail.auth.valid-secondary-failure', ['user' => $notifiable]);
        }

        return $message
            ->greeting(__('Hello :name', ['name' => $notifiable->name]))
            ->line('A recent attempt to log in with your secondary email address has failed.')
            ->line('This email address must be validated before a log in will succeed.')
            ->line('Please log in with your primary email address and navigate to your profile to send a new verification email.');
    }

    /**
     *  Get the notification's delivery channels.
     *
     *  @param  mixed  $notifiable
     *  @return array
     */
    public function via($notifiable)
    {
        return $notifiable->notificationChannels();
    }
}
