<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'genre_code',
        'year',
        'poster_filename',
        'synopsis',
        'trailer_url',
    ];

    public function getImageExistsAttribute()
    {
        return Storage::exists("public/posters/{$this->poster_filename}");
    }

    public function getImageUrlAttribute()
    {
        if ($this->getImageExistsAttribute()) {
            return asset("storage/posters/{$this->poster_filename}");
        } else {
            return asset("storage/posters/_no_poster_2.png");
        }
    }

    public function genre(): BelongsTo{
        return $this->belongsTo(Genre::class, 'code', 'genre_code')->withTrashed();
    }

    public function screenings(): HasMany{
        return $this->hasMany(Screening::class);
    }

}
