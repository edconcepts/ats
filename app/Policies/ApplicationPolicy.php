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
        return $user->isAdmin;
    }

    public function update(User $user, Application $application): bool
    {
        return $user->isAdmin;
    }

    public function delete(User $user, Application $application): bool
    {
        return ($user->isAdmin || $user->isHr) && ! $application->trashed();
    }
}
