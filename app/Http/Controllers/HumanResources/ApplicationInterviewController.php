<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\StoreApplicationInterviewRequest;
use App\Models\Application;
use App\Models\StoreManagerTimeSlot;
use App\Notifications\InterviewCanceledNotification;
use App\Notifications\InterviewScheduledNotification;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ApplicationInterviewController extends Controller
{
    public function store(Application $application, StoreApplicationInterviewRequest $request): RedirectResponse
    {
        $timeSlotId = $request->validated('timeSlot');

        $application->interview()->updateOrCreate(
            [
                'application_id' => $application->id
            ],
            [
                'store_manager_time_slot_id' => $timeSlotId,
            ]
        );
        // Re-load potentially eager loaded (null) interview.
        $application->load('interview');

        // TODO: Perhaps not hardcoded ID?
        // Set status to "Gesprek ingepland"
        $application->status()->associate(7);
        $application->save();

        try {
            $timeSlot = StoreManagerTimeSlot::find($timeSlotId);
            $timeSlot->storeManager->notify(new InterviewScheduledNotification($application));
        } catch (\RuntimeException $e) {
            // Credentials not set. Probably local environment.
            report($e);
        }

        return redirect()->route('dashboard');
    }

    public function cancel(Application $application): RedirectResponse
    {
        $timeSlot = $application->interview->storeManagerTimeSlot;
        $manager = $timeSlot->storeManager;

        // TODO: Default casting as datetime would help
        $date = Carbon::createFromTimeString($timeSlot->start)->format('d-m-Y H:i');

        $application->interview->delete();

        // TODO: Perhaps not hardcoded ID?
        // Set status to "Gesolliciteerd"
        $application->status()->associate(2);
        $application->save();

        $message = "Hierbij bevestigen wij dat het gesprek op {$date} is geannuleerd. Indien nodig nemen we contact met je op.";

        try {
            $manager->notify(new InterviewCanceledNotification($application, $message));
        } catch (\RuntimeException $e) {
            // Credentials not set. Probably local environment.
            report($e);
        }

        try {
            $application->notify(new InterviewCanceledNotification($application, $message));
        } catch (\RuntimeException $e) {
            // Credentials not set. Probably local environment.
            report($e);
        }

        return redirect()->route('dashboard');
    }
}
