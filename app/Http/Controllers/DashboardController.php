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
        // TODO the idea is on having multiple roles, but it seems user only has one role, rn we go for checking for the hr and ..., change if needed
        if(auth()->user()->is_hr)
        {
            $statuses = Status::with('applications', 'applications.vacancy')->get();
            return Inertia::render('HR/Dashboard', [
                'statuses' =>  StatusResource::collection($statuses)
            ]);
        }elseif(auth()->user()->is_store_manager)
        {
            return Inertia::render('/Dashboard');
        }else{
            return Inertia::render('/Dashboard');

        }
    }
}
