<?php

namespace App\Observers;

use App\Models\Status;

class StatusObserver
{
    public function deleting(Status $status): void
    {
        // TODO: Maybe we can apply a short?
        // Move related applications into "gesolliciteerd"
        $status->applications()->update([
            'status_id' => 2,
        ]);
    }
}
