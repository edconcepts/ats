<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\UpdateStoreManagerRequest;
use App\Models\Location;
use App\Models\Role;
use App\Models\User;
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
            'location' => $location->load('manager')
        ]);
    }

    public function update(UpdateStoreManagerRequest $request, Location $location)
    {
        $values = [
            'name' => $request->input('name'),
        ];

        if ($request->input('password')) {
            $values['password'] = bcrypt($request->input('password'));
        }

        $user = $location
            ->manager()
            ->updateOrCreate(
                [
                    'email' => $request->input('email'),
                ],
                $values,
            );

        $storeManagerRole = Role::query()
            ->where('name','store_manager')
            ->first();

        $user->roles()->sync($storeManagerRole);

        $location->user_id = $user->id;
        $location->save();

        return redirect()->route('hr.locations.index');
    }
}
