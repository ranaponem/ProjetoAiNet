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

    //create the view function
    //check if the user is an admin or the customer
    //TODO
    public function view(User $user, Customer $customer): bool
    {
        return $user->type === 'A' || $user->id === $customer->user_id;
    }




    public function __construct()
    {
        //
    }
}
