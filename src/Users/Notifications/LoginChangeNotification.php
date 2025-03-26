<?php

namespace Enraiged\Users\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     *  Get the mail representation of the notification.
     *
     *  @param  mixed  $notifiable
     *  @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject(__('Login Change'));

        if (config('enraiged.app.mail_markdown') === true) {
            return $message
                ->markdown('mail.auth.login.change', ['user' => $notifiable]);
        }

        return (new MailMessage)
            ->greeting(__('Hello :name', ['name' => $notifiable->name]))
            ->line(__('There have been changes to your account login.'))
            ->line(__('If this update is unexpected, please take immediate action to protect your account by changing your password.'))
            ->line(__('Feel free to contact the support team if you have questions or require assistance.'));
    }

    /**
     *  Get the notification's delivery channels.
     *
     *  @param  mixed  $notifiable
     *  @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }
}
