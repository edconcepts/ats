<?php

namespace App\Http\Controllers;

use App\Models\Application;

class ApplicationNotesUpdateController extends Controller
{
    public function __invoke(Application $application)
    {
        $this->authorize('update', $application);

        $application->update([
            'notes' => request('notes')
        ]);
    }
}
