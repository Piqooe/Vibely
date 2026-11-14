<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Song extends Model
{
    protected $fillable = [
        'artist_id',
        'album_id',
        'title',
        'slug',
        'audio_url',
        'duration',
        'plays',
        'track_number',
    ];

    protected function casts(): array
    {
        return [
            'duration' => 'integer',
            'plays' => 'integer',
            'track_number' => 'integer',
        ];
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    public function playlists(): BelongsToMany
    {
        return $this->belongsToMany(Playlist::class, 'playlist_song')
            ->withPivot('position')
            ->withTimestamps();
    }

    public function likedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'liked_songs')
            ->withTimestamps();
    }
    
    protected function coverUrl(): Attribute
    {
        return Attribute::get(fn () => $this->album?->cover_url);
    }

    protected function artwork(): Attribute
    {
        return Attribute::get(fn () => $this->album?->artwork ?? $this->artist?->artwork ?? ['pattern' => 'orb', 'palette' => 'violet']);
    }

    protected function isLiked(): Attribute
    {
        return Attribute::get(function () {
            if (array_key_exists('is_liked', $this->attributes)) {
                return (bool) $this->attributes['is_liked'];
            }

            $userId = Auth::id() ?? 1;
            return $this->likedByUsers()->where('user_id', $userId)->exists();
        });
    }
}