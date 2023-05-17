<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Http\Requests\HR\UpdateApplicationStatusRequest;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    public function update(Application $application, UpdateApplicationStatusRequest $request)
    {
        $application->update([
            'status_id' => $request->status
        ]);

        return redirect(route('hr.dashboard.index'));
    }
}
