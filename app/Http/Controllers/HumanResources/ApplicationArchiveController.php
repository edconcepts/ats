<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationArchiveController extends Controller
{
    public function update(Application $application)
    {
        $application->archive();

        return redirect(route('dashboard'));
    }
}
