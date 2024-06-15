<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

class CustomerPolicy
{
    // Before method to grant unrestricted access to administrators
    public function before(User $user): ?bool
    {
        if ($user->type === 'A') {
            return true; // Allows unrestricted access for administrators
        }
        return null; // Does not interfere with individual method checks
    }

    // Determines if the user can view a list of customers
    public function viewAny(User $user): bool
    {
        return $user->type === 'A'; // Only administrators can view all customers
    }

    // Determines if the user can view a specific customer
    public function view(User $user, Customer $customer): bool
    {
        $aux = $customer->user;
        return $user->type === 'A' || ($user->id === $aux->id && $user->type === 'C');
        // Allows administrators or the customer themselves to view the customer
    }

    // Determines if the user can create a new customer
    public function create(User $user): bool
    {
        return $user->type === 'C'; // Only customers can create new customers
    }

    // Determines if the user can update a customer
    public function update(User $user, Customer $customer): bool
    {
        $aux = $customer->user;
        return $user->type === 'A' || ($user->id === $aux->id && $user->type === 'C');
        // Allows administrators or the customer themselves to update the customer
    }

    // Determines if the user can delete a customer
    public function delete(User $user, Customer $customer): bool
    {
        $aux = $customer->user;
        return $user->type === 'A' || ($user->id === $aux->id && $user->type === 'C');
        // Allows administrators or the customer themselves to delete the customer
    }
}
