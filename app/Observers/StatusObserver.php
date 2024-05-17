<?php

namespace App\Observers;

use App\Models\Status;

class StatusObserver
{
    public function deleting(Status $status): void
    {
        // TODO: Maybe we can apply a short?
        // TODO: Check if we need to update the kik_application_status value
        // Move related applications into archive
        $status->applications()->update([
            'status_id' => config('status.archive_status_id'),
        ]);
    }
}
