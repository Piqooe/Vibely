<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'alya@mosing.app'],
            [
                'name' => 'Alya Putri',
                'avatar_url' => null,
                'password' => Hash::make('password'),
            ]
        );

        $artistsData = [
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
        ];

        $artists = [];
        foreach ($artistsData as $item) {
            $slug = str($item['name'])->slug()->toString();
            $artists[$slug] = Artist::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $item['name'],
                    'photo_url' => null,
                    'artwork' => ['palette' => $item['palette']],
                ]
            );
        }

        $albumsData = [
            ['Midnight Echoes', 'luna-arden', 2026, 'orb', 'blue', null],
            ['Neon Horizon', 'the-velvet-kites', 2025, 'bands', 'red', null],
            ['Golden Hour Drive', 'sora-malik', 2026, 'rings', 'amber', null],
            ['Ocean Letters', 'nadia-rae', 2024, 'horizon', 'violet', null],
            ['Paper Planets', 'kiko-the-moons', 2025, 'orb', 'green', null],
            ['Senja di Kota', 'aruna', 2026, 'bands', 'pink', null],
            ['Electric Bloom', 'nova', 2026, 'rings', 'teal', "A neon-soaked journey through late-night synths and euphoric hooks. NOVA's sophomore record is out now — only on MoSing."],
            ['Quiet Storms', 'elio-hart', 2023, 'horizon', 'rose', null],
            ['Lost in Tokyo', 'hikari-sun', 2025, 'orb', 'lime', null],
            ['Velvet Nights', 'mara-quinn', 2024, 'bands', 'orange', null],
            ['Wildflower Season', 'june-avenue', 2025, 'rings', 'indigo', null],
            ['After Rain', 'danu-pratama', 2026, 'horizon', 'fuchsia', null],
        ];

        $albums = [];
        foreach ($albumsData as $item) {
            $slug = str($item[0])->slug()->toString();
            $artist = $artists[$item[1]];

            $albums[$slug] = Album::updateOrCreate(
                ['slug' => $slug],
                [
                    'artist_id' => $artist->id,
                    'title' => $item[0],
                    'type' => 'Album',
                    'release_year' => $item[2],
                    'cover_url' => null,
                    'artwork' => ['pattern' => $item[3], 'palette' => $item[4]],
                    'description' => $item[5],
                ]
            );
        }

        $songsData = [
            ['Starlight Avenue', 'midnight-echoes', 222, 48201733, true, 1],
            ['Hold On to Summer', 'golden-hour-drive', 198, 36912045, false, 1],
            ['Neon Rain', 'neon-horizon', 245, 29550118, true, 1],
            ['Kota Tanpa Tidur', 'senja-di-kota', 231, 22104987, false, 1],
            ['Paper Hearts', 'paper-planets', 179, 18744302, false, 1],
        ];

        $songs = [];
        foreach ($songsData as $item) {
            $slug = str($item[0])->slug()->toString();
            $album = $albums[$item[1]];

            $song = Song::updateOrCreate(
                ['slug' => $slug],
                [
                    'artist_id' => $album->artist_id,
                    'album_id' => $album->id,
                    'title' => $item[0],
                    'audio_url' => null,
                    'duration' => $item[2],
                    'plays' => $item[3],
                    'track_number' => $item[5],
                ]
            );

            $songs[$slug] = $song;

            if ($item[4]) {
                $user->likedSongs()->syncWithoutDetaching([$song->id]);
            }
        }

        $playlistsData = [
            ['Chill Vibes', 'Lo-fi beats and soft acoustic for slow evenings.', null, 'MoSing', 'horizon', 'violet'],
            ['Focus Flow', 'Instrumental tracks to keep you in the zone.', $user->id, 'Alya Putri', 'orb', 'green'],
            ['Indie Pagi', 'Fresh local indie to start your morning right.', $user->id, 'Alya Putri', 'bands', 'pink'],
            ['Late Night Drive', 'Synthwave and city pop for the open road.', null, 'MoSing', 'rings', 'teal'],
            ['Workout Energy', 'High-BPM bangers to push your limits.', $user->id, 'Alya Putri', 'horizon', 'rose'],
            ['Lofi Study', 'Calm, steady beats for deep study sessions.', $user->id, 'Alya Putri', 'orb', 'lime'],
        ];

        $playlists = [];
        foreach ($playlistsData as $item) {
            $slug = str($item[0])->slug()->toString();
            $playlists[$slug] = Playlist::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $item[2],
                    'owner_name' => $item[3],
                    'title' => $item[0],
                    'description' => $item[1],
                    'cover_url' => null,
                    'artwork' => ['pattern' => $item[4], 'palette' => $item[5]],
                    'is_public' => true,
                ]
            );
        }
        
        $playlists['chill-vibes']->songs()->syncWithoutDetaching([
            $songs['starlight-avenue']->id => ['position' => 1],
            $songs['kota-tanpa-tidur']->id => ['position' => 2],
            $songs['paper-hearts']->id => ['position' => 3],
        ]);

        $playlists['late-night-drive']->songs()->syncWithoutDetaching([
            $songs['neon-rain']->id => ['position' => 1],
            $songs['hold-on-to-summer']->id => ['position' => 2],
            $songs['starlight-avenue']->id => ['position' => 3],
        ]);
    }
}