<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'theater_id',
        'row',
        'seat_number',
    ];
}
