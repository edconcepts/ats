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
        $this->authorize('changeStatus', $application);

        $application->status_id = $request->status;
        $application->save();

        return redirect()->route('dashboard');
    }
}
