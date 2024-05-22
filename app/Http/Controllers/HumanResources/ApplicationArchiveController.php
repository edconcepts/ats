<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationArchiveController extends Controller
{
    public function update(Application $application)
    {
        $application->update(['status_id' => config('status.archive_status_id')]);

        return redirect(route('dashboard'));
    }
}
