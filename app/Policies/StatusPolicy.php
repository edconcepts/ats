<?php

namespace App\Policies;

use App\Models\User;

class StatusPolicy
{
    /**
     * Create a new policy instance.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->roll === 'admin' ) {
            return true;
        }

        return null;
    }
}
