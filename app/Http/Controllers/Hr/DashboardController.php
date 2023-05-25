<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Resources\HR\StatusResource;
use App\Models\Application;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $statuses = Status::with('applications', 'applications.vacancy')->get();
        return Inertia::render('HR/Dashboard', [
            'statuses' =>  StatusResource::collection($statuses)
        ]);
    }

    public function show_application(Application $application)
    {
        return Inertia::modal('HR/Application', [
            'application' => $application->load('vacancy.location.manager.timeSlots', 'status'),
            'statuses' =>  Status::all(),
        ])->baseRoute('hr.dashboard.index');
    }
}
