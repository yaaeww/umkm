<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PeringatanUmkmNotification extends Notification
{
    use Queueable;

    protected $subject;
    protected $message;

    public function __construct($subject, $message)
    {
        $this->subject = $subject;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail']; // bisa ditambah 'database' jika diperlukan
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting('Halo ' . $notifiable->name . ',')
            ->line($this->message)
            ->line('Silakan hubungi admin jika Anda memiliki pertanyaan lebih lanjut.');
    }
}

