<?php

namespace App\Http\Controllers\HumanResources;

use App\Events\ApplicationStatusChangedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\HumanResources\UpdateApplicationStatusRequest;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    public function update(Application $application, UpdateApplicationStatusRequest $request)
    {
        $application->update([
            'status_id' => $request->status
        ]);

        if($application->wasChanged())
        {
            ApplicationStatusChangedEvent::dispatch($application);
        }

        return redirect(route('dashboard.index'));
    }
}
