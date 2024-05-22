<?php

namespace App\Providers;

use App\Listeners\UserLoggedInListener;
use App\Models\Application;
use App\Observers\ApplicationObserver;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ApplicationStatusChangedEvent;
use App\Listeners\SendApplicationStatusChangedMail;
use App\Listeners\SendApplicationStatusChangedNotification;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */

    //TODO : make a subscriber for Application changes if other events where added
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ApplicationStatusChangedEvent::class => [
            SendApplicationStatusChangedMail::class
        ],
        Login::class => [
            UserLoggedInListener::class,
        ],
    ];

    protected $observers = [
        Application::class => [
            ApplicationObserver::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
