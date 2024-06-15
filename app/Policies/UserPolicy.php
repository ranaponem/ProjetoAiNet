<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user): ?bool
    {
        if ($user->type === 'A') {
            return true; // Admin can bypass all other checks
        }
        return null; // Non-admin users do not automatically pass
    }

    public function update(User $userUpdating, User $userToUpdate): bool
    {
        return $user->type === 'A'; // Only admin can delete photos
    }

    public function viewAny(User $user): bool
    {
        // Only admins can view any users
        return $user->type === 'A';
    }

    public function view(User $user): bool
    {
        // Only admins can view a user
        return $user->type === 'A';
    }

    public function create(User $user): bool
    {
        // Only admins can create new users
        return $user->type === 'A';
    }

    public function delete(User $user, Customer $customer): bool
    {
        // Only admins can delete customers
        return $user->type === 'A';
    }
    public function destroyPhoto(User $user): bool
    {
        return $user->type === 'A'; // Only admin can delete photos
    }
}
