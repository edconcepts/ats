<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendNotificationStoreRequest;
use App\Models\Location;
use App\Models\User;
use Inertia\Inertia;

class SendNotificationController extends Controller
{
    public function index()
    {
        $locations = Location::query()->withWhereHas('manager')->get();

        // Format to array with user ID as key and name as value
        $locations = $locations->mapWithKeys(function ($location) {
            return [$location->manager->id => $location->manager->name . ' - ' . $location->name];
        });

        return Inertia::render('HR/SendNotification/Send', [
            'locations' => $locations,
        ]);
    }

    public function store(SendNotificationStoreRequest $request)
    {
        $recipients = User::whereIn('id', $request->recipients)->get();

        $recipients->each(function ($recipient) use ($request) {
            $recipient->notify(new \App\Notifications\CustomNotification($request->message));
        });
    }
}
