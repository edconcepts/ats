<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\StoreStatusRequest;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StatusController extends Controller
{

    public function index()
    {
        $this->authorize('index', Status::class);

        return Inertia::render('HR/Statuses/Overview', [
                'statuses' => Status::all()
        ]);
    }

    public function create()
    {
        $this->authorize('create', Status::class);
        return Inertia::render('HR/Statuses/Create');
    }

    public function store(StoreStatusRequest $request)
    {
        $this->authorize('store', Status::class);

        $status = Status::create(['name'=> $request->name]);

        if($request->hasEmail){
            $status->email()->create([
                'subject' => $request->email['subject'],
                'body' => $request->email['body']
            ]);
        }

        return redirect(route('statuses.index'));
    }

    public function edit(Status $status)
    {
        $this->authorize('edit', $status);

        return Inertia::render('HR/Statuses/Edit', ['status' => $status->load('email')]);
    }

    public function update(Status $status, StoreStatusRequest $request)
    {
        $this->authorize('update', $status);

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
        return redirect(route('statuses.index'));

    }
}
