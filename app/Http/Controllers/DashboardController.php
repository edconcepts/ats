<?php

namespace App\Http\Controllers;

use App\Http\Resources\HR\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        if(auth()->user()->isHR) {
            $statuses = Status::with('applications', 'applications.vacancy')->get();
            return Inertia::render('HR/Dashboard', [
                'statuses' => StatusResource::collection($statuses)
            ]);
        }
        elseif (auth()->user()->isStoreManager) {
            $locations = auth()->user()->locations;
            return Inertia::render('StoreManager/Dashboard', [
                'locations' => $locations
            ]);
        }
    }
}
