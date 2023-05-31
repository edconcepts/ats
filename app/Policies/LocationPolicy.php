<?php

namespace App\Policies;

use App\Models\User;

class LocationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function index(User $user): bool
    {
        return $user->role == 'admin';
    }
    public function edit(User $user): bool
    {
        return $user->role == 'admin';
    }
    public function update(User $user): bool
    {
        return $user->role == 'admin';
    }
}
