<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'code';
    protected $fillable = [
        'code',
        'name',
    ];

    public function movies(): HasMany{
        return $this->hasMany(Movie::class, 'genre_code', 'code')->withTrashed();
    }
}
