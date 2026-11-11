@extends('layouts.app')

@section('title', 'UI Kit')

@section('content')
    @php($label = 'mb-4 text-xs font-bold tracking-[1px] text-muted uppercase')

    <div class="flex flex-col gap-10 px-4 pt-2 pb-10 md:px-6">
        <div>
            <h1 class="text-[32px] font-bold tracking-[-0.6px]">Components</h1>
            <p class="mt-1 text-sm text-text-secondary">Komponen Blade reusable Vibely. Arahkan kursor ke kartu/baris untuk melihat state hover.</p>
        </div>

        <section>
            <h2 class="{{ $label }}">Buttons</h2>
            <div class="flex flex-wrap items-center gap-4">
                <x-button variant="primary" icon="play">Play</x-button>
                <x-button variant="secondary" icon="plus">Save to Library</x-button>
                <x-button variant="dark">Upgrade</x-button>
                <x-button variant="danger" icon="trash-2">Delete</x-button>
                <x-button variant="ghost">Cancel</x-button>
                <x-button variant="primary" disabled>Disabled</x-button>
            </div>
        </section>

        <section>
            <h2 class="{{ $label }}">Play buttons</h2>
            <div class="flex items-center gap-5">
                <x-play-button size="sm" />
                <x-play-button size="lg" />
                <x-play-button size="xl" class="shadow-[0_8px_24px_rgb(0_191_255/0.25)]" />
                <x-play-button size="xl" icon="pause" label="Pause" />
            </div>
        </section>

        <section>
            <h2 class="{{ $label }}">Chips</h2>
            <div class="flex gap-3">
                <x-chip active>All</x-chip>
                <x-chip>Indie</x-chip>
            </div>
        </section>

        <section>
            <h2 class="{{ $label }}">Cards (default · artist · skeleton)</h2>
            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-6">
                @php($album = $featuredAlbums[0])
                <x-music-card :title="$album->title" :subtitle="$album->release_year.' • '.$album->artist->name" :art="$album->artwork" />
                @php($album = $featuredAlbums[2])
                <x-music-card :title="$album->title" :subtitle="$album->release_year.' • '.$album->artist->name" :art="$album->artwork" />
                <x-music-card circle :title="$recommendedArtists[0]->name" subtitle="Artist" :art="$recommendedArtists[0]->artwork" />
                <x-music-card circle :title="$recommendedArtists[1]->name" subtitle="Artist" :art="$recommendedArtists[1]->artwork" />
                <x-music-card-skeleton />
                <x-music-card-skeleton circle />
            </div>
        </section>

        <section>
            <h2 class="{{ $label }}">Loading — Featured Albums</h2>
            <div class="flex gap-3.5 overflow-x-auto scrollbar-none md:grid md:grid-cols-4 md:gap-3 xl:grid-cols-6">
                @foreach (range(1, 6) as $i)
                    <x-music-card-skeleton />
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="{{ $label }}">Quick access cards (playing · default)</h2>
            <div class="grid max-w-3xl grid-cols-1 gap-3 sm:grid-cols-3">
                @foreach ($recentlyPlayed->take(3) as $item)
                    <x-quick-card :title="$item->title" :art="$item->artwork" :playing="$item->is_playing" :liked="$item->type === 'liked'" />
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="{{ $label }}">Track rows (playing · default)</h2>
            <div class="max-w-5xl">
                @foreach ($popularSongs->take(3) as $song)
                    <x-track-row :song="$song" :index="$loop->iteration" :playing="$loop->first" meta="3 days ago" />
                @endforeach
            </div>
        </section>

        <section>
            <h2 class="{{ $label }}">Empty states</h2>
            <div class="grid gap-6 lg:grid-cols-2">
                <x-empty-state icon="search" title="No results found" message="Try different keywords or check the spelling."
                    class="border border-border">
                    <x-button variant="secondary">Browse genres</x-button>
                </x-empty-state>
                <x-empty-state icon="music" title="This playlist is empty" message="Find songs you love and add them here."
                    class="border border-border">
                    <x-button variant="primary" icon="search">Find songs</x-button>
                </x-empty-state>
            </div>
        </section>
    </div>
@endsection
