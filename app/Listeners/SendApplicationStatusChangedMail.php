<?php

namespace App\Listeners;

use App\Events\ApplicationStatusChangedEvent;
use App\Mail\ApplicationStatusChangedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendApplicationStatusChangedMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {}

    /**
     * Handle the event.
     */
    public function handle(ApplicationStatusChangedEvent $event): void
    {
        $mail = $event->application->status->email;
        if($mail){
            Mail::to($event->application->email)
            ->queue(new ApplicationStatusChangedMail($mail));
        }
    }
}
