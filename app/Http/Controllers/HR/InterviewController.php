<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\StoreInterviewRequest;
use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function store(StoreInterviewRequest $request)
    {
        Interview::UpdateOrCreate([
            [
                'application_id' => $request->application,
            ],
            [
                'store_manager_time_slot_id' => $request->timeSlot,
            ]
        ]);

        return redirect(route('dashboard'));
    }
}
