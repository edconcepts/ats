<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class InterviewScheduledNotification extends Notification
{
    public function __construct(public Application $application)
    {
    }

    public function via($notifiable): array
    {
        return ['database', VonageSmsChannel::class];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'message' => 'Er is een nieuw sollicitatiegesprek ingepland op ' . $this->application->interview->storeManagerTimeSlot->start . ' voor de vacature ' . $this->application->vacancy->title . '.',
            'url' => route('dashboard'),
        ];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content('Er is een nieuw sollicitatiegesprek ingepland.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
