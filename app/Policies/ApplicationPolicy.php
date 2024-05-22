<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    public function index(User $user): bool
    {
        return $user->isAdmin;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin || $user->isHr;
    }

    public function update(User $user, Application $application): bool
    {
        // All roles can update an application (add notes)
        return true;
    }

    public function changeStatus(User $user, Application $application): bool
    {
        // Only area manager cannot change the status.
        return $user->isAdmin || $user->isHr || $user->isStoreManager;
    }

    public function archive(User $user, Application $application): bool
    {
        // Only HR and admin can archive the application. Technically updating a status, but different policy needed.
        return $user->isAdmin || $user->isHr;
    }

    public function delete(User $user, Application $application): bool
    {
        return ($user->isAdmin || $user->isHr) && ! $application->trashed();
    }
}
