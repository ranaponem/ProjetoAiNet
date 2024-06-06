<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
