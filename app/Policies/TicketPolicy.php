<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->type === 'A';
    }

    public function view(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        if($user->type === 'E'){
            return false;
        }
        return true;
    }

    public function update(User $user): bool
    {
        return $user->type === 'A';
    }

    public function delete(User $user): bool
    {
        return $user->type === 'A' ;
    }

    public function validate(User $user): bool
    {
        return $user->type === 'E';
    }
}
