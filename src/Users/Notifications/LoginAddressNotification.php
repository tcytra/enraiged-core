<?php

namespace Enraiged\Users\Notifications;

use Enraiged\Network\Models\IpAddress;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginAddressNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     *  Create an instance of the LoginAddressNotification.
     *
     *  @param  \Enraiged\Network\Models\IpAddress  $ipAddress
     */
    public function __construct(
        private IpAddress $ipAddress,
    )
    {}

    /**
     *  Get the mail representation of the notification.
     *
     *  @param  mixed  $notifiable
     *  @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $message = (new MailMessage)
            ->subject(__('New Device Login'));

        if ($notifiable->usernameIsEmailAddress) {
            $message->cc($notifiable->username, $notifiable->name);
        }

        if (config('enraiged.app.mail_markdown') === true) {
            return $message
                ->markdown('mail.auth.login-address', [
                    'address' => $this->ipAddress,
                    'user' => $notifiable,
                ]);
        }

        return $message
            ->greeting(__('Hello :name', ['name' => $notifiable->name]))
            ->line(__('There has just been a login to your account from a new device or ip address.'))
            ->line(__('The ip address is: :address', ['address' => $this->ipAddress->ip_address]))
            ->line(__('The login credential is: :credential', ['credential' => $this->ipAddress->credential]))
            ->line(__('If this login is unexpected, please take immediate action to protect your account by changing your password.'))
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
        return $notifiable->notificationChannels();
    }
}
