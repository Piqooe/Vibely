<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use App\Support\DummyMusic;
use App\Support\Format;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = Auth::user() ?? User::first();

        $albums = Album::with('artist')
            ->withCount('songs')
            ->withSum('songs as total_duration', 'duration')
            ->get()
            ->keyBy('slug');

        $playlists = Playlist::with('user')
            ->withCount('songs')
            ->get()
            ->keyBy('slug');

        $artists = Artist::all()->keyBy('slug');

        $popularSongs = Song::with(['artist', 'album'])
            ->orderByDesc('plays')
            ->take(5)
            ->get();

        $quick = fn (string $type, object $item, bool $playing = false) => (object) [
            'type' => $type,
            'title' => $item->title,
            'cover_url' => $item->cover_url,
            'artwork' => (array) $item->artwork,
            'is_playing' => $playing,
        ];

        $recentlyPlayed = collect([
            isset($playlists['chill-vibes']) ? $quick('playlist', $playlists['chill-vibes'], true) : null,
            isset($albums['midnight-echoes']) ? $quick('album', $albums['midnight-echoes']) : null,
            (object) ['type' => 'liked', 'title' => 'Liked Songs', 'cover_url' => null, 'artwork' => null, 'is_playing' => false],
            isset($playlists['focus-flow']) ? $quick('playlist', $playlists['focus-flow']) : null,
            isset($albums['senja-di-kota']) ? $quick('album', $albums['senja-di-kota']) : null,
            isset($playlists['late-night-drive']) ? $quick('playlist', $playlists['late-night-drive']) : null,
            isset($albums['neon-horizon']) ? $quick('album', $albums['neon-horizon']) : null,
            isset($playlists['indie-pagi']) ? $quick('playlist', $playlists['indie-pagi']) : null,
        ])->filter()->values();

        $newRelease = $albums['electric-bloom'] ?? $albums->first();

        $pick = fn ($collection, array $slugs) => collect($slugs)
            ->map(fn ($slug) => $collection[$slug] ?? null)
            ->filter()
            ->values();

        return view('home', [
            'user' => $user,
            'greeting' => Format::greeting(),
            'genres' => ['All', 'Pop', 'Indie', 'Lo-fi', 'Jazz', 'Podcasts'],
            'mobileFilters' => ['All', 'Music', 'Playlists', 'Podcasts'],
            'recentlyPlayed' => $recentlyPlayed,
            'newRelease' => $newRelease,
            'newReleases' => $pick($albums, ['electric-bloom', 'quiet-storms', 'lost-in-tokyo', 'velvet-nights', 'wildflower-season', 'after-rain']),
            'popularSongs' => $popularSongs,
            'featuredAlbums' => $pick($albums, ['midnight-echoes', 'neon-horizon', 'golden-hour-drive', 'ocean-letters', 'paper-planets', 'senja-di-kota']),
            'featuredPlaylists' => $playlists->values(),
            'recommendedArtists' => $pick($artists, ['luna-arden', 'sora-malik', 'nova', 'elio-hart', 'nadia-rae', 'aruna']),
            'recommendedMusic' => $pick($albums, ['electric-bloom', 'quiet-storms', 'lost-in-tokyo', 'velvet-nights', 'wildflower-season', 'after-rain']),
        ]);
    }

    public function uiKit(): View
    {
        return view('ui-kit', DummyMusic::home());
    }
}