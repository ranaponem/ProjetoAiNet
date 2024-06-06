<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seat extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $fillable = [
        'theater_id',
        'row',
        'seat_number',
    ];

    public function theater(): BelongsTo{
        return $this->belongsTo(Theater::class);
    }

    public function tickets(): HasMany{
        return $this->hasMany(Ticket::class);
    }
}
