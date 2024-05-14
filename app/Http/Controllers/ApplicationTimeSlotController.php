<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\StoreManagerTimeSlot;
use App\Notifications\InterviewScheduled;
use App\Notifications\InterviewScheduledNotification;

class ApplicationTimeSlotController extends Controller
{
    public function index()
    {

    }

    public function store(Application $application, StoreManagerTimeSlot $timeSlot)
    {
        dd('1');
        StoreManagerTimeSlot::query()
            ->where('application_id', $application->id)
            ->update(['application_id' => null]);

        $timeSlot->application()->associate($application);
        $timeSlot->save();

        $application->status()->associate(5);
        $application->save();
    }
}
