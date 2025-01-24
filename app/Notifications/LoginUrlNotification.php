<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class LoginUrlNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $token, $expiry;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $expiry)
    {
        $this->token = $token;
        $this->expiry = $expiry;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = URL::temporarySignedRoute('verify-login', $this->expiry, [ "token" => $this->token ]);
        return (new MailMessage)
                    ->subject('Login to Facility Booking Portal')
                    ->line('Your Portal Access Link is ready.')
                    ->action('Login Now', $url)
                    ->line('Do Not share this link. This is a personal Portal Access Link. Sharing this link is same as sharing your password');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
