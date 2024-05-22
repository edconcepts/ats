<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class InterviewCanceledNotification extends Notification
{
    public function __construct(public Application $application, public string $message)
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
