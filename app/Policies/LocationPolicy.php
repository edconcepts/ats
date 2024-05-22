<?php

namespace App\Policies;

use App\Models\User;

class LocationPolicy
{
    public function index(User $user): bool
    {
        return $user->isAdmin;
    }

    public function edit(User $user): bool
    {
        return $user->isAdmin;
    }

    public function update(User $user): bool
    {
        return $user->isAdmin;
    }
}
