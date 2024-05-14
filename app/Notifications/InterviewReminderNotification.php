<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class InterviewReminderNotification extends Notification
{
    public function __construct(public Application $application, public $message)
    {
    }

    public function via($notifiable): array
    {
        return [VonageSmsChannel::class];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->message);
    }
}
