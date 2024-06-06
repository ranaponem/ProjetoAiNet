<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'theater_id',
        'date',
        'start_time',
    ];
}
