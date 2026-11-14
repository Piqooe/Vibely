<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artist extends Model
{
    protected $fillable = [
        'name', 'slug', 'photo_url', 'artwork',
    ];

    protected function casts(): array
    {
        return [
            'artwork' => 'array',
        ];
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }
}