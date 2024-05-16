<?php

namespace App\Listeners;

use App\Notifications\TwoFactorAuthenticationCodeNotification;
use Illuminate\Auth\Events\Login;
use IlluminateAuthEventsLogin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLoggedInListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        if ($event->user->role !== 'store_manager')
            return;

        if (session()->get('2fa:verified', false))
            return;

        // generate a 6 digit code here and store it in the database
        $code = mt_rand(100000, 999999);

        $event->user->two_factor_code = $code;
        $event->user->two_factor_expires_at = now()->addMinutes(10);
        $event->user->save();

        try {
             // send the code to the user via SMS
             $event->user->notify(new TwoFactorAuthenticationCodeNotification($event->user));
        } catch (\RuntimeException $exception) {
            // Credentials not set. Probably local environment.
        }
    }
}
