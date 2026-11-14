<?php

namespace App\Support;

use Illuminate\Support\Collection;

class DummyMusic
{
    public static function user(): object
    {
        return self::obj(['id' => 1, 'name' => 'Alya Putri', 'avatar_url' => null]);
    }

    public static function artists(): Collection
    {
        return self::keyed([
            ['name' => 'Luna Arden', 'palette' => 'blue'],
            ['name' => 'The Velvet Kites', 'palette' => 'red'],
            ['name' => 'Sora Malik', 'palette' => 'red'],
            ['name' => 'Nadia Rae', 'palette' => 'green'],
            ['name' => 'Kiko & The Moons', 'palette' => 'green'],
            ['name' => 'Aruna', 'palette' => 'pink'],
            ['name' => 'NOVA', 'palette' => 'amber'],
            ['name' => 'Elio Hart', 'palette' => 'violet'],
            ['name' => 'Hikari Sun', 'palette' => 'lime'],
            ['name' => 'Mara Quinn', 'palette' => 'orange'],
            ['name' => 'June Avenue', 'palette' => 'indigo'],
            ['name' => 'Danu Pratama', 'palette' => 'fuchsia'],
        ], fn ($a, $i) => [
            'id' => $i + 1,
            'name' => $a['name'],
            'slug' => str($a['name'])->slug()->toString(),
            'photo_url' => null,
            'artwork' => ['palette' => $a['palette']],
        ], 'slug');
    }

    public static function albums(): Collection
    {
        $artists = self::artists();

        return self::keyed([
            ['Midnight Echoes', 'luna-arden', 2026, 'orb', 'blue', 11, 2538],
            ['Neon Horizon', 'the-velvet-kites', 2025, 'bands', 'red', 10, 2412],
            ['Golden Hour Drive', 'sora-malik', 2026, 'rings', 'amber', 12, 2765],
            ['Ocean Letters', 'nadia-rae', 2024, 'horizon', 'violet', 9, 2104],
            ['Paper Planets', 'kiko-the-moons', 2025, 'orb', 'green', 10, 2230],
            ['Senja di Kota', 'aruna', 2026, 'bands', 'pink', 8, 1922],
            ['Electric Bloom', 'nova', 2026, 'rings', 'teal', 12, 2460],
            ['Quiet Storms', 'elio-hart', 2023, 'horizon', 'rose', 10, 2321],
            ['Lost in Tokyo', 'hikari-sun', 2025, 'orb', 'lime', 11, 2587],
            ['Velvet Nights', 'mara-quinn', 2024, 'bands', 'orange', 9, 2049],
            ['Wildflower Season', 'june-avenue', 2025, 'rings', 'indigo', 13, 2896],
            ['After Rain', 'danu-pratama', 2026, 'horizon', 'fuchsia', 8, 1876],
        ], fn ($a, $i) => [
            'id' => $i + 1,
            'title' => $a[0],
            'slug' => str($a[0])->slug()->toString(),
            'type' => 'Album',
            'artist' => ['id' => $artists[$a[1]]->id, 'name' => $artists[$a[1]]->name],
            'release_year' => $a[2],
            'cover_url' => null,
            'artwork' => ['pattern' => $a[3], 'palette' => $a[4]],
            'songs_count' => $a[5],
            'total_duration' => $a[6],
            'description' => null,
        ], 'slug');
    }

    public static function popularSongs(): Collection
    {
        $albums = self::albums();

        return collect([
            ['Starlight Avenue', 'midnight-echoes', 222, 48201733, true],
            ['Hold On to Summer', 'golden-hour-drive', 198, 36912045, false],
            ['Neon Rain', 'neon-horizon', 245, 29550118, true],
            ['Kota Tanpa Tidur', 'senja-di-kota', 231, 22104987, false],
            ['Paper Hearts', 'paper-planets', 179, 18744302, false],
        ])->map(fn ($s, $i) => self::song($i + 1, $s[0], $albums[$s[1]], $s[2], $s[3], $s[4]));
    }

    public static function playlists(): Collection
    {
        return self::keyed([
            ['Chill Vibes', 'Lo-fi beats and soft acoustic for slow evenings.', 'MoSing', 'horizon', 'violet', 42],
            ['Focus Flow', 'Instrumental tracks to keep you in the zone.', 'Alya Putri', 'orb', 'green', 35],
            ['Indie Pagi', 'Fresh local indie to start your morning right.', 'Alya Putri', 'bands', 'pink', 28],
            ['Late Night Drive', 'Synthwave and city pop for the open road.', 'MoSing', 'rings', 'teal', 50],
            ['Workout Energy', 'High-BPM bangers to push your limits.', 'Alya Putri', 'horizon', 'rose', 46],
            ['Lofi Study', 'Calm, steady beats for deep study sessions.', 'Alya Putri', 'orb', 'lime', 64],
        ], fn ($p, $i) => [
            'id' => $i + 1,
            'title' => $p[0],
            'slug' => str($p[0])->slug()->toString(),
            'description' => $p[1],
            'owner' => ['name' => $p[2]],
            'cover_url' => null,
            'artwork' => ['pattern' => $p[3], 'palette' => $p[4]],
            'songs_count' => $p[5],
        ], 'slug');
    }

    public static function nowPlaying(): object
    {
        $song = self::popularSongs()->first();
        $song->position = 84;

        return $song;
    }

    public static function library(): Collection
    {
        $p = self::playlists();
        $a = self::artists();

        return collect([
            self::obj(['type' => 'liked', 'title' => 'Liked Songs', 'subtitle' => 'Playlist • 128 songs', 'is_playing' => false]),
            self::libraryItem('playlist', $p['chill-vibes'], true),
            self::libraryItem('playlist', $p['focus-flow']),
            self::libraryItem('playlist', $p['indie-pagi']),
            self::libraryItem('artist', $a['luna-arden']),
            self::libraryItem('playlist', $p['late-night-drive']),
            self::libraryItem('playlist', $p['workout-energy']),
            self::libraryItem('playlist', $p['lofi-study']),
        ]);
    }

    public static function home(): array
    {
        $albums = self::albums();
        $playlists = self::playlists();
        $artists = self::artists();

        $quick = fn ($type, $item, $playing = false) => self::obj([
            'type' => $type,
            'title' => $item->title,
            'cover_url' => $item->cover_url,
            'artwork' => (array) $item->artwork,
            'is_playing' => $playing,
        ]);

        $newRelease = $albums['electric-bloom'];
        $newRelease->description = "A neon-soaked journey through late-night synths and euphoric hooks. NOVA's sophomore record is out now — only on MoSing.";

        return [
            'user' => self::user(),
            'greeting' => Format::greeting(),
            'genres' => ['All', 'Pop', 'Indie', 'Lo-fi', 'Jazz', 'Podcasts'],
            'mobileFilters' => ['All', 'Music', 'Playlists', 'Podcasts'],

            'recentlyPlayed' => collect([
                $quick('playlist', $playlists['chill-vibes'], true),
                $quick('album', $albums['midnight-echoes']),
                self::obj(['type' => 'liked', 'title' => 'Liked Songs', 'cover_url' => null, 'artwork' => null, 'is_playing' => false]),
                $quick('playlist', $playlists['focus-flow']),
                $quick('album', $albums['senja-di-kota']),
                $quick('playlist', $playlists['late-night-drive']),
                $quick('album', $albums['neon-horizon']),
                $quick('playlist', $playlists['indie-pagi']),
            ]),

            'newRelease' => $newRelease,
            'newReleases' => self::pick($albums, ['electric-bloom', 'quiet-storms', 'lost-in-tokyo', 'velvet-nights', 'wildflower-season', 'after-rain']),
            'popularSongs' => self::popularSongs(),
            'featuredAlbums' => self::pick($albums, ['midnight-echoes', 'neon-horizon', 'golden-hour-drive', 'ocean-letters', 'paper-planets', 'senja-di-kota']),
            'featuredPlaylists' => $playlists->values(),
            'recommendedArtists' => self::pick($artists, ['luna-arden', 'sora-malik', 'nova', 'elio-hart', 'nadia-rae', 'aruna']),
            'recommendedMusic' => self::pick($albums, ['electric-bloom', 'quiet-storms', 'lost-in-tokyo', 'velvet-nights', 'wildflower-season', 'after-rain']),
        ];
    }

    private static function song(int $id, string $title, object $album, int $duration, int $plays, bool $liked): object
    {
        return self::obj([
            'id' => $id,
            'title' => $title,
            'artist' => (array) $album->artist,
            'album' => ['id' => $album->id, 'title' => $album->title],
            'cover_url' => $album->cover_url,
            'artwork' => (array) $album->artwork,
            'duration' => $duration,
            'plays' => $plays,
            'is_liked' => $liked,
        ]);
    }

    private static function libraryItem(string $type, object $item, bool $playing = false): object
    {
        return self::obj([
            'type' => $type,
            'title' => $item->title ?? $item->name,
            'subtitle' => $type === 'artist' ? 'Artist' : 'Playlist • '.$item->owner->name,
            'cover_url' => $item->cover_url ?? $item->photo_url ?? null,
            'artwork' => (array) $item->artwork,
            'is_playing' => $playing,
        ]);
    }

    private static function pick(Collection $items, array $slugs): Collection
    {
        return collect($slugs)->map(fn ($slug) => $items[$slug])->values();
    }

    private static function keyed(array $rows, callable $map, string $key): Collection
    {
        return collect($rows)->map($map)->map(fn ($row) => self::obj($row))->keyBy($key);
    }

    private static function obj(array $data): object
    {
        return json_decode(json_encode($data));
    }
}
