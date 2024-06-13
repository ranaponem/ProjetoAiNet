<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    //Miguel Silva
    //create the before function
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


    public function view(User $user, Customer $customer): bool
    {
        $aux = $customer->user();
        return $user->type === 'A' || ($user->id === $aux->id && $user->type === 'C');
    }

    public function create(User $user): bool
    {
        return $user->type === 'C';
    }

    public function update(User $user, Customer $customer): bool
    {
        $aux = $customer->user();
        return $user->type === 'A' || ($user->id === $aux->id && $user->type === 'C');
    }

    public function delete(User $user, Customer $customer): bool
    {
        $aux = $customer->user();
        return $user->type === 'A' || ($user->id === $aux->id && $user->type === 'C');
    }

}
