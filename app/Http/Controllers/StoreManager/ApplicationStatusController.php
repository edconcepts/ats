<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;

class ApplicationStatusController extends Controller
{
    public function update(Application $application, Status $status)
    {
        $application->update(['status_id' => $status->id]);

        $storeManager = $application->vacancy->location->manager;
        Auth::login($storeManager);

        return redirect()->route('dashboard')->with('success', 'Application Status Changed To '.$status->name. '!');
    }
}
