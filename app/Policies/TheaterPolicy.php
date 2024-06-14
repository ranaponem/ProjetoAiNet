<?php

namespace App\Policies;

use App\Models\Theater;
use App\Models\User;

class TheaterPolicy
{
    public function before(User $user): ?bool
    {
        if ($user->type === 'A') {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->type === 'A';
    }


    public function view(User $user): bool
    {
        return $user->type === 'A';
    }

    public function create(User $user): bool
    {
        return $user->type === 'A';
    }

    public function update(User $user, Theater $theater): bool
    {
        return $user->type === 'A';
    }

    public function delete(User $user, Theater $theater): bool
    {
        return $user->type === 'A';
    }
}
