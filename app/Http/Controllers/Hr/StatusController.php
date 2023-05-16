<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hr\StoreStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function index()
    {
        return Inertia::render('HR/Statuses/Overview', [
                'statuses' => Status::all()
        ]);
    }

    public function store(StoreStatusRequest $request)
    {
        dd($request);
    }

}
