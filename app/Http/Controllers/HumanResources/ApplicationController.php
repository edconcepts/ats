<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Interview;
use App\Notifications\InterviewCanceledNotification;
use Carbon\Carbon;

class ApplicationController extends Controller
{
    public function destroy(Application $application)
    {
        $this->authorize('delete', $application);

        // Cancel existing appointment if needed.
        if ($application->interview instanceof Interview) {
            $date = Carbon::createFromTimeString($application->interview->storeManagerTimeSlot->start)->format('d-m-Y H:i');

            $application->interview->delete();

            $message = "Hierbij bevestigen wij dat het gesprek op {$date} is geannuleerd. Indien nodig nemen we contact met je op.";

            try {
                $application->vacancy->location->manager->notify(new InterviewCanceledNotification($application, $message));
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
        }

        $application->delete();

        return redirect()->route('dashboard');
    }
}
