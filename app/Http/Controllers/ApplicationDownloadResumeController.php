<?php

namespace App\Http\Controllers;

use App\Models\Application;

class ApplicationDownloadResumeController extends Controller
{
    public function __invoke(Application $application)
    {
        if(filter_var($application->resume , FILTER_VALIDATE_URL)){
            return redirect()->away($application->resume);
        } else{
            return response()->download(storage_path('app/public/'.$application->resume));
        }
    }
}
