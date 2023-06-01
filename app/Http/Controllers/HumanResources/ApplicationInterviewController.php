<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\StoreApplicationInterviewRequest;
use App\Models\Application;
use App\Models\Interview;
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
        return redirect(route('dashboard'));
    }
}
