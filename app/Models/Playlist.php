<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Playlist extends Model
{
    protected $fillable = [
        'user_id',
        'owner_name',
        'title',
        'slug',
        'description',
        'cover_url',
        'artwork',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'artwork' => 'array',
            'is_public' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function songs(): BelongsToMany
    {
        return $this->belongsToMany(Song::class, 'playlist_song')
            ->withPivot('position')
            ->orderByPivot('position')
            ->withTimestamps();
    }
    
    protected function owner(): Attribute
    {
        return Attribute::get(fn () => (object) [
            'name' => $this->user?->name ?? $this->owner_name ?? 'MoSing',
        ]);
    }
}