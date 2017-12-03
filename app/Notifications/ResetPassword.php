<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPassword extends Notification
{
    use Queueable;

    protected $token;

    public function __construct($token) {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail(){
        return (new MailMessage)
            ->view('emails.reset_password', ['token' => $this->token]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
