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
            return true; // Admin pode ignorar todas as outras verificações
        }
        return null; // Outros tipos de utilizador não passam automaticamente
    }

    public function update(User $user, Customer $customer): bool
    {
        return $user->id === $customer->user_id;
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


    public function delete(User $user, Customer $customer): bool
    {
        $aux = $customer->user();
        return $user->type === 'A' ;
    }

}
