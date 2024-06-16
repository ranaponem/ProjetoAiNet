<?php
namespace App\Policies;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchasePolicy
{
use HandlesAuthorization;
    public function before(User $user)
    {
        if ($user->type === 'A') {
            return true;
        }
    }
    public function view(User $user, Purchase $purchase)
    {
        // Assuming each purchase has a customer relationship and each customer has a user_id
        return $user->id === $purchase->customer_id;
    }
}
