<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\StatusResource;
use App\Models\Application;
use App\Models\Status;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $statuses = Status::query()
            ->with('applications', 'applications.vacancy')
            ->get();
        dd($statuses);
        return Inertia::render('HR/Dashboard', [
            'statuses' =>  StatusResource::collection($statuses)
        ]);
    }

    public function show_application(Application $application)
    {
        $application->load('vacancy.location.manager.timeSlots', 'status');
        return Inertia::modal('HR/Application', [
            'application' => $application,
            'statuses' =>  Status::all(),
        ])->baseRoute('dashboard');
    }
}
