<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nif',
        'payment_type',
        'payment_ref',
    ];

    public $incrementing = false;


    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id', 'id')->withTrashed();
    }

    public function purchases(): HasMany{
        return $this->hasMany(Purchase::class);
    }
}
