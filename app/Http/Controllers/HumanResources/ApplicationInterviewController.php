<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\StoreApplicationInterviewRequest;
use App\Models\Application;
use App\Notifications\InterviewScheduledNotification;
use Illuminate\Http\Request;

class ApplicationInterviewController extends Controller
{
    public function store(Application $application, StoreApplicationInterviewRequest $request)
    {
        $application->interview()->UpdateOrCreate(
            [
                'application_id' => $application->id
            ],
            [
                'store_manager_time_slot_id' => $request->timeSlot,
            ]
        );

        $application->status()->associate(7);
        $application->save();

        $application->vacancy->location->manager->notify(new InterviewScheduledNotification($application));

        return redirect(route('dashboard'));
    }
}
