<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\UpdateStoreManagerRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    public function index()
    {
        //TODO pass only necessory columns on this and status
        return Inertia::render('HR/Locations/Overview',[
            'locations' => Location::all()
        ]);
    }

    public function edit(Location $location)
    {
        return Inertia::render('HR/Locations/Edit',[
            'location' => $location
        ]);
    }

    public function update(UpdateStoreManagerRequest $request, Location $location)
    {
        // TODO: Implement update() method.
    }
}
