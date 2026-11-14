<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    public function index(): JsonResponse
    {
        $playlists = Playlist::with('user')
            ->withCount('songs')
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $playlists,
        ]);
    }

    public function show(Playlist $playlist): JsonResponse
    {
        $playlist->load(['user', 'songs.artist', 'songs.album'])
            ->loadCount('songs');

        return response()->json([
            'status' => 'success',
            'data' => $playlist,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
            'pattern' => ['nullable', 'string', 'in:orb,bands,rings,horizon'],
            'palette' => ['nullable', 'string'],
        ]);

        $user = Auth::user() ?? User::first();
        $baseSlug = str($validated['title'])->slug()->toString();
        $slug = Playlist::where('slug', $baseSlug)->exists()
            ? $baseSlug . '-' . now()->timestamp
            : $baseSlug;

        $playlist = Playlist::create([
            'user_id' => $user?->id,
            'owner_name' => $user?->name ?? 'MoSing',
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'artwork' => [
                'pattern' => $validated['pattern'] ?? 'orb',
                'palette' => $validated['palette'] ?? 'violet',
            ],
            'is_public' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Playlist berhasil dibuat',
            'data' => $playlist,
        ], 201);
    }

    public function addSong(Request $request, Playlist $playlist): JsonResponse
    {
        $validated = $request->validate([
            'song_id' => ['required', 'exists:songs,id'],
        ]);

        $nextPosition = ($playlist->songs()->max('playlist_song.position') ?? 0) + 1;
        $playlist->songs()->syncWithoutDetaching([
            $validated['song_id'] => ['position' => $nextPosition],
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Lagu ditambahkan ke playlist',
            'songs_count' => $playlist->songs()->count(),
        ]);
    }

    public function removeSong(Playlist $playlist, Song $song): JsonResponse
    {
        $playlist->songs()->detach($song->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Lagu dihapus dari playlist',
            'songs_count' => $playlist->songs()->count(),
        ]);
    }
}