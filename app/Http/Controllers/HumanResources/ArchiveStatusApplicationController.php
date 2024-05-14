<?php

namespace App\Http\Controllers\HumanResources;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;

class ArchiveStatusApplicationController extends Controller
{
    public function __invoke(Status $status)
    {
        $status->applications()->update(['status_id' => config('status.archive_status_id')]);
        return redirect(route('dashboard'));
    }
}
