<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Song;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $q = trim((string) $request->query('q', ''));

        if ($q === '') {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'songs' => [],
                    'albums' => [],
                    'artists' => [],
                    'playlists' => [],
                ],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'songs' => Song::with(['artist', 'album'])
                    ->where('title', 'like', "%{$q}%")
                    ->take(10)
                    ->get(),
                'albums' => Album::with('artist')
                    ->where('title', 'like', "%{$q}%")
                    ->take(6)
                    ->get(),
                'artists' => Artist::where('name', 'like', "%{$q}%")
                    ->take(6)
                    ->get(),
                'playlists' => Playlist::withCount('songs')
                    ->where('title', 'like', "%{$q}%")
                    ->take(6)
                    ->get(),
            ],
        ]);
    }
}