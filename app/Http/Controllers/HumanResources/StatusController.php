<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Http\Middleware\HumanResource\EnsureStatusIsEditable;
use App\Http\Requests\HumanResources\StoreStatusRequest;
use App\Models\Status;
use App\Support\Shortcodes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware(EnsureStatusIsEditable::class)->only(['update', 'edit']);
    }

    public function index()
    {
        $this->authorize('index', Status::class);

        // TODO: Visible scope / query instead of hiding in DOM?
        return Inertia::render('HR/Statuses/Overview', [
            'archive_status_id' => config('status.archive_status_id'),
            'fixed_status_ids' => config('status.fixed_status_ids'),
            'statuses' => Status::withCount('applications')->get(),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Status::class);
        return Inertia::render('HR/Statuses/Create', [
            'shortcodes' => Shortcodes::getShortcodes(),
        ]);
    }

    public function store(StoreStatusRequest $request)
    {
        $this->authorize('create', Status::class);

        $status = Status::create(['name'=> $request->name]);

        if($request->hasEmail){
            $status->email()->create([
                'subject' => $request->email['subject'],
                'body' => $request->email['body']
            ]);
        }

        return redirect()->route('statuses.index');
    }

    public function edit(Status $status)
    {
        $this->authorize('update', $status);

        return Inertia::render('HR/Statuses/Edit', [
            'status' => $status->load('email'),
            'shortcodes' => Shortcodes::getShortcodes(),
        ]);
    }

    public function update(Status $status, StoreStatusRequest $request)
    {
        $this->authorize('update', $status);

        $status->update(['name' => $request->name]);

        if ($request->hasEmail) {
            $status->email()->updateOrCreate(
                ['status_id' => $status->id],
                [
                    'subject' => $request->email['subject'],
                    'body' => $request->email['body']
                ]
            );
        } else {
            $status->email()->delete();
        }

        return redirect()->route('statuses.index');
    }

    public function destroy(Status $status)
    {
        $this->authorize('delete', $status);

        $status->delete();

        //return redirect()
        //    ->back()
        //    ->with('success', "Status {$status->name} is verwijderd.");
    }

    public function reorder(Request $request): void
    {
        $reorderData = $request->all();
        $newOrder = $reorderData['newIndex'];
        $oldOrder = $reorderData['oldIndex'];

        if ($newOrder > $oldOrder) {
            DB::table('statuses')
                ->where('order', '>=', $oldOrder)
                ->where('order', '<=', $newOrder)
                ->decrement('order');
        } else {
            DB::table('statuses')
                ->where('order', '>=', $newOrder)
                ->where('order', '<=', $oldOrder)
                ->increment('order');
        }

        DB::table('statuses')->where('id', $reorderData['id'])->update(['order' => $newOrder]);
    }
}
