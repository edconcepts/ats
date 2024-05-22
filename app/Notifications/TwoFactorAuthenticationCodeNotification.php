<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Channels\VonageSmsChannel;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class TwoFactorAuthenticationCodeNotification extends Notification
{
    public function __construct(public User $user)
    {
    }

    public function via($notifiable): array
    {
        return [VonageSmsChannel::class];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content($this->user->two_factor_code . ' is je beveiligingscode.');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
