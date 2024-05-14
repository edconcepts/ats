<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\UpdateStoreManagerRequest;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{

    public function index()
    {
        $this->authorize('index', Location::class);

        return Inertia::render('HR/Locations/Overview',[
            'locations' => Location::query()->orderBy('name')->get()
        ]);
    }

    public function edit(Location $location)
    {
        $this->authorize('edit', $location);

        return Inertia::render('HR/Locations/Edit',[
            'location' => $location->load('manager'),
        ]);
    }

    public function update(UpdateStoreManagerRequest $request, Location $location)
    {
        $this->authorize('update', $location);

        $storeManagerValues = [
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'role' => 'store_manager',
        ];

        if ($request->input('password')) {
            $storeManagerValues['password'] = bcrypt($request->input('password'));
        }

        $locationValues = [
            'regio_manager_name' => $request->input('regio_manager_name'),
            'regio_manager_email' => $request->input('regio_manager_email'),
            'location_address' => $request->input('location_address')
        ];


        $location->update($locationValues);


        $user = $location
            ->manager()
            ->updateOrCreate(
                [
                    'location_id' => $location->id,
                ],
                $storeManagerValues,
            );

        return redirect()->route('locations.index');
    }

    public function login(Location $location)
    {
        $user = $location->manager;

        auth()->login($user);
        session(['2fa:verified' => true]);

        return redirect()->route('dashboard');
    }
}
