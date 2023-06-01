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

    public function index()
    {
        $this->authorize('index', Location::class);

        return Inertia::render('HR/Locations/Overview',[
            'locations' => Location::all()
        ]);
    }

    public function edit(Location $location)
    {
        $this->authorize('edit', $location);

        return Inertia::render('HR/Locations/Edit',[
            'location' => $location->load('manager')
        ]);
    }

    public function update(UpdateStoreManagerRequest $request, Location $location)
    {
        $this->authorize('update', $location);

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
