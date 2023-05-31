<?php

namespace App\Http\Controllers;

use App\Http\Resources\HR\StatusResource;
use App\Models\Application;
use App\Models\Status;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        //TODO: refactor this filtering, and also maybe change dashbaords links
        if(auth()->user()->isHR) {
            $statuses = Status::query()
                ->when(request()->input('search'), function($query, $search){
                    $query->whereHas('applications', function(Builder $query) use ($search){
                        $query->where('title', 'like', "%{$search}%")
                            ->orWhere('slug', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('phone_number', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhereHas('vacancy', function($query) use ($search){
                                $query->where('slug', 'like', "%{$search}%")
                                    ->orWhere('title', 'like', "%{$search}%")
                                    ->orWhereHas('location', function($query) use ($search){
                                        $query->where('name', 'like', "%{$search}%")
                                            ->orWhere('description', 'like', "%{$search}%");
                                    });
                            });
                    });
                })
                ->with('applications', 'applications.vacancy')->get();
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
        $endDate = Carbon::now()->setISODate(Carbon::now()->year, $weekNumber, 7);

        $workdays = [];

        while ($startDate <= $endDate) {
//            if ($startDate->isWeekday()) {
                $timeslots = [];
                for ($i = 8; $i <= 21; $i++) {
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
                    'localized' => $startDate->locale('nl')->isoFormat('dddd D MMMM'),
                    'timeslots' => $timeslots,
                ];

                $workdays[] = $workday;
//            }

            $startDate->addDay();
        }

        return $workdays;
    }
}
