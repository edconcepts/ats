<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    public function index()
    {
        //TODO pass only necessory columns on this and status
        return Inertia::render('HR/Locations',[
            'locations' => Location::all()
        ]);
    }
}
