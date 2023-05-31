<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\StoreStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Status::class, 'status');
    }

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

        if($request->hasEmail){
            $status->email()->create([
                'subject' => $request->email['subject'],
                'body' => $request->email['body']
            ]);
        }

        return redirect(route('hr.statuses.index'));
    }

    public function edit(Status $status)
    {
        return Inertia::render('HR/Statuses/Edit', ['status' => $status->load('email')]);
    }

    public function update(Status $status, StoreStatusRequest $request)
    {
        $status->update(['name' => $request->name]);

        if($request->hasEmail){
            $status->email()->updateOrCreate(
                ['status_id' => $status->id],
                [
                    'subject' => $request->email['subject'],
                    'body' => $request->email['body']
                ]
            );
        }else{
            $status->email()?->delete();
        }
        return redirect(route('hr.statuses.index'));

    }
}
