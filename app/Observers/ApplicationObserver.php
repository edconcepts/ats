<?php

namespace App\Observers;

use App\Events\ApplicationStatusChangedEvent;
use App\Models\Application;

class ApplicationObserver
{
    public function created(Application $application): void
    {
        ApplicationStatusChangedEvent::dispatch($application);
    }

    public function updated(Application $application): void
    {
        if ($application->isDirty('status_id')) {
            ApplicationStatusChangedEvent::dispatch($application);
        }
    }
}
