<?php

namespace App\Policies;

use App\Models\Configuration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConfigurationPolicy
{
    use HandlesAuthorization;

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

    public function update(User $user): bool
    {
        return $user->type === 'A';
    }

    public function delete(User $user): bool
    {
        return $user->type === 'A';
    }
}
