<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\UpdateStoreManagerRequest;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Location::class, 'location');
    }

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
            'location' => $location->load('manager')
        ]);
    }

    public function update(UpdateStoreManagerRequest $request, Location $location)
    {
        $values = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'role' => 'store_manager',
        ];

        if ($request->input('password')) {
            $values['password'] = bcrypt($request->input('password'));
        }

        $user = $location
            ->manager()
            ->updateOrCreate(
                [
                    'location_id' => $location->id,
                ],
                $values,
            );

        return redirect()->route('locations.index');
    }
}
