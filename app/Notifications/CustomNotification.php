<?php

namespace App\Notifications;

use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class CustomNotification extends Notification
{
    public function __construct(public string $message)
    {
    }

    public function via($notifiable): array
    {
        return ['database', VonageSmsChannel::class];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => $this->message,
            'url' => route('dashboard'),
        ];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->message);
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
