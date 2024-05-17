<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\User;

class StatusPolicy
{
    /**
     * Create a new policy instance.
     */
    public function index(User $user): bool
    {
        return $user->isAdmin;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin;
    }

    public function update(User $user, Status $status): bool
    {
        return $user->isAdmin;
    }

    public function delete(User $user, Status $status): bool
    {
        // Cannot delete a status that is the archive status or the fixed ID from the database...
        return $user->isAdmin && ! in_array($status->id, [config('status.archive_status_id'), 2]);
    }
}
