<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'total_price',
        'customer_name',
        'customer_email',
        'nif',
        'payment_type',
        'payment_ref',
        'receipt_pdf_filename',
    ];

    public function customer(): HasOne{
        return $this->hasOne(Customer::class)->withTrashed();
    }

    public function tickets(): HasMany{
        return $this->hasMany(Ticket::class);
    }

    // Method to create tickets from cart items
    public function createTicketsFromCart($cart)
    {
        foreach ($cart as $item) {
            // Assuming you have a Ticket model and its relationship correctly defined
            $ticket = $this->tickets()->create([
                'screening_id' => $item['screening_id'],
                'seat_id' => $item['seat_id'],
                'price' => $item['price'],
            ]);

            // Perform any additional operations related to tickets if needed
            // For example, sending notifications, updating seat availability, etc.
        }
    }
}
