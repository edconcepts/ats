<?php

namespace App\Http\Controllers;

use App\Http\Resources\HR\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if(auth()->user()->isHR) {
            $statuses = Status::with('applications', 'applications.vacancy')->get();
            return Inertia::render('HR/Dashboard', [
                'statuses' => StatusResource::collection($statuses),
            ]);
        }
        elseif (auth()->user()->isStoreManager) {

            $locations = auth()->user()->locations;

            return Inertia::render('StoreManager/Dashboard', [
                'locations' => $locations,
                'days' => $this->getWorkdaysOfWeek(request()->get('week') ?? null),
                'week' => request()->get('week') ?? Carbon::now()->weekOfYear,
            ]);
        }
    }

    function getWorkdaysOfWeek($weekNumber = null)
    {
        $weekNumber = $weekNumber ?? Carbon::now()->weekOfYear;

        $startDate = Carbon::now()->setISODate(Carbon::now()->year, $weekNumber, 1);
        $endDate = Carbon::now()->setISODate(Carbon::now()->year, $weekNumber, 5);

        $workdays = [];

        while ($startDate <= $endDate) {
            if ($startDate->isWeekday()) {
                $timeslots = [];
                for ($i = 8; $i <= 18; $i++) {
                    $timeslots[] = [
                        'iso' => $startDate->copy()->setHour($i)->setMinute(0),
                        'formatted' => $startDate->copy()->setHour($i)->setMinute(0)->format('H:i'),
                        'end_formatted' => $startDate->copy()->setHour($i + 1)->setMinute(0)->format('H:i'),
                        'is_checked' => auth()->user()->timeSlots()->where('start', $startDate->copy()->setHour($i)->setMinute(0)->setSecond(0)->format('Y-m-d H:i:s'))->exists(),
                    ];
                }

                $workday = [
                    'iso' => $startDate->copy(),
                    'formatted' => $startDate->format('d-m-Y'),
                    'timeslots' => $timeslots,
                ];

                $workdays[] = $workday;
            }

            $startDate->addDay();
        }

        return $workdays;
    }
}
