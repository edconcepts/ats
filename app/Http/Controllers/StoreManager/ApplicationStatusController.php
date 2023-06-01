<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Status;

class ApplicationStatusController extends Controller
{
    public function update(Application $application, Status $status)
    {
        $application->update(['status_id' => $status->id]);
        //TODO return what?
        dd($application);
    }
}
