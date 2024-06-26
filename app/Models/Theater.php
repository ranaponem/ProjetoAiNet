<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Theater extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'photo_filename',
    ];

    public function getImageExistsAttribute()
    {
        return $this->photo_filename === NULL ? false : Storage::exists("public/photos/{$this->photo_filename}");
    }

    public function getImageUrlAttribute()
    {
        if ($this->imageExists) {
            return asset("storage/photos/{$this->photo_filename}");
        }
        else{
            return asset("storage/posters/_no_poster_1.png");
        }
    }

    public function seats(): HasMany{
        return $this->hasMany(Seat::class);
    }

    public function screenings(): HasMany{
        return $this->hasMany(Screening::class);
    }
}
