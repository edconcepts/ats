<?php

namespace App\Http\Controllers\HR;

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

    public function create()
    {
        return Inertia::render('HR/Statuses/Create');
    }

    public function store(StoreStatusRequest $request)
    {
        $status = Status::create(['name'=> $request->name]);

        if($request->email['subject']){
            $status->emails()->create([
                'subject' => $request->email['subject'],
                'body' => $request->email['body']
            ]);
        }

        return redirect(route('hr.statuses'));
    }

}
