<?php

namespace App\Policies;

use App\Models\User;

class VacancyPolicy
{
    /**
     * Create a new policy instance.
     */
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

    public function create(User $user): bool
    {
        return $user->isAdmin;
    }

    public function store(User $user): bool
    {
        return $user->isAdmin;
    }

    public function delete(User $user): bool
    {
        return $user->isAdmin;
    }
}
