<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TimeSlotController extends Controller
{
    public function __invoke()
    {
        $date = Carbon::parse(request('timeslot')['iso']);

        $date->setSecond(0)->setMicro(0)->format('Y-m-d H:i:s');

        if ($timeslot = auth()->user()->timeSlots()->where('start', $date)->first()) {
            $timeslot->delete();
        }
        else {
            auth()->user()->timeSlots()->create([
                'start' => $date,
            ]);
        }
    }
}
