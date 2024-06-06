<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'photo_filename',
    ];
}
