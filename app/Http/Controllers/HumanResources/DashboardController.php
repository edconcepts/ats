<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Resources\HR\StatusResource;
use App\Models\Application;
use App\Models\Location;
use App\Models\Status;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $statuses = Status::query()
            ->with('applications', 'applications.vacancy')
            ->get();

        return Inertia::render('HR/Dashboard', [
            'statuses' =>  StatusResource::collection($statuses)
        ]);
    }

    public function show_application(Application $application)
    {
        $locations = Location::withWhereHas(
            'manager.availableTimeSlots',
            fn ($query) => $query->where('start', '>=', now())->orderBy('start')
        )->get()->keyBy('id');

        $application->load([
            'vacancy.location',
            'interview.storeManagerTimeSlot.storeManager.location',
            'status'
        ]);

        return Inertia::modal('HR/Application', [
            'locations' => $locations,
            'application' => $application,
            'statuses' =>  auth()->user()->role === 'store_manager'
                // Afgewezen / hired if store manager
                ? [ Status::find(3), Status::find(9) ]
                : Status::all(),
            'interviewTimeSlot' => $application->interview?->storeManagerTimeSlot
        ])->baseRoute('dashboard');
    }

    public function add_application()
    {
        return Inertia::modal('HR/AddApplication', [
            'defaultStatusId' => Arr::first(Arr::wrap(config('status.fixed_status_ids'))),
            'statuses' => Status::all(),
            'vacancies' => Vacancy::with('location')->get(),
        ])->baseRoute('dashboard');
    }

    public function store_application(StoreApplicationRequest $request)
    {
        $data = $request->validated();
        $data['title'] = "Sollicitatie {$data['name']} - {$data['vacancy_id']}";
        $data['slug'] = Str::slug($data['title']);
        $data['kik_date']  = now();

        $uploadedFile = $request->file('cv');

        if ($uploadedFile){
            $data['resume'] = $uploadedFile->store('resumes', 'public');
        }

        $application = Application::create($data);

        return redirect()->route('dashboard.application.show', $application);
    }
}
