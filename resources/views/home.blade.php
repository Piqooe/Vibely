@extends('layouts.app')

@section('title', 'Home')

@php
    $rail = 'flex gap-3.5 overflow-x-auto snap-x snap-mandatory scroll-px-4 -mx-4 px-4 scrollbar-none *:snap-start
             md:mx-0 md:grid md:grid-cols-4 md:gap-3 md:overflow-visible md:px-0 xl:grid-cols-6
             md:max-xl:[&>*:nth-child(n+5)]:hidden';
    $firstName = str($user->name)->before(' ');
@endphp

@section('content')
    <section class="px-4 pt-1 pb-3 md:px-6 md:pt-2 md:pb-6">
        <div class="-mx-4 mb-4 flex items-center gap-3 overflow-x-auto px-4 pt-1 scrollbar-none md:hidden">
            <span class="flex size-8 shrink-0 items-center justify-center rounded-full bg-linear-to-br from-[#8B5CF6] to-[#1E1B4B] text-xs font-bold">
                {{ \App\Support\Format::initials($user->name) }}
            </span>
            @foreach ($mobileFilters as $filter)
                <x-chip :active="$loop->first">{{ $filter }}</x-chip>
            @endforeach
        </div>

        <h1 class="text-[22px] font-bold tracking-[-0.4px] md:text-[32px] md:tracking-[-0.6px]">{{ $greeting }}, {{ $firstName }}</h1>

        <div class="mt-5 hidden flex-wrap gap-2 md:flex">
            @foreach ($genres as $genre)
                <x-chip :active="$loop->first">{{ $genre }}</x-chip>
            @endforeach
        </div>
    </section>

    <div class="flex flex-col gap-6 px-4 pb-6 md:gap-10 md:px-6 md:pt-2">

        <section class="flex flex-col gap-4">
            <x-section-header title="Recently Played" class="hidden md:flex" />
            <div class="grid grid-cols-2 gap-2 md:gap-3 xl:grid-cols-4 max-md:[&>*:nth-child(n+7)]:hidden md:max-xl:[&>*:nth-child(n+5)]:hidden">
                @foreach ($recentlyPlayed as $item)
                    <x-quick-card :title="$item->title" :cover="$item->cover_url" :art="$item->artwork"
                        :playing="$item->is_playing" :liked="$item->type === 'liked'" />
                @endforeach
            </div>
        </section>

        <section class="flex flex-col gap-3 md:gap-4">
            <x-section-header title="New Releases" href="#" />

            <article class="hidden items-center gap-6 rounded-lg border border-border bg-linear-to-r from-[#5B1660] to-card/0 p-6 md:flex lg:gap-8 lg:p-7">
                <x-cover :src="$newRelease->cover_url" :art="$newRelease->artwork" :seed="$newRelease->title"
                    :label="$newRelease->title" label-size="text-sm"
                    class="size-40 rounded-md shadow-[0_8px_24px_rgb(0_0_0/0.5)] lg:size-[200px]" />

                <div class="flex min-w-0 flex-1 flex-col gap-2.5">
                    <p class="text-xs font-bold tracking-[1.5px] text-accent">NEW RELEASE</p>
                    <h3 class="truncate text-4xl leading-tight font-bold tracking-[-1.2px] lg:text-5xl">{{ $newRelease->title }}</h3>
                    <p class="text-sm font-semibold">
                        {{ $newRelease->artist->name }}<span class="mx-2">•</span>{{ $newRelease->type }}<span class="mx-2">•</span>{{ $newRelease->release_year }}<span class="mx-2">•</span>{{ $newRelease->songs_count }} songs, {{ \App\Support\Format::minutes($newRelease->total_duration) }}
                    </p>
                    @if ($newRelease->description)
                        <p class="line-clamp-2 max-w-[520px] text-sm leading-[21px] text-text-secondary">{{ $newRelease->description }}</p>
                    @endif
                    <div class="mt-4 flex items-center gap-3">
                        <x-button variant="primary" icon="play">Play</x-button>
                        <x-button variant="secondary" icon="plus">Save to Library</x-button>
                        <button type="button" aria-label="More options"
                            class="flex size-10 items-center justify-center rounded-full text-text-secondary transition-colors hover:text-white">
                            <x-lucide-ellipsis class="size-5" />
                        </button>
                    </div>
                </div>
            </article>

            <div class="{{ $rail }} md:hidden!">
                @foreach ($newReleases as $album)
                    <x-music-card :title="$album->title" :subtitle="$album->artist->name.' • '.$album->type"
                        :cover="$album->cover_url" :art="$album->artwork" />
                @endforeach
            </div>
        </section>

        <section class="flex flex-col gap-3 md:gap-4">
            <x-section-header title="Popular Songs" eyebrow="This week on Vibely" href="#" link-text="See more" />
            <div class="-mx-2 flex flex-col md:mx-0">
                @foreach ($popularSongs as $song)
                    <x-track-row :song="$song" :index="$loop->iteration" :playing="$song->id === $nowPlaying->id" />
                @endforeach
            </div>
        </section>

        <section class="flex flex-col gap-3 md:gap-4">
            <x-section-header title="Featured Albums" href="#" />
            <div class="{{ $rail }}">
                @foreach ($featuredAlbums as $album)
                    <x-music-card :title="$album->title" :subtitle="$album->release_year.' • '.$album->artist->name"
                        :cover="$album->cover_url" :art="$album->artwork" />
                @endforeach
            </div>
        </section>

        <section class="flex flex-col gap-3 md:gap-4">
            <x-section-header title="Featured Playlists" :eyebrow="'Made for '.$firstName" href="#" />
            <div class="{{ $rail }}">
                @foreach ($featuredPlaylists as $playlist)
                    <x-music-card :title="$playlist->title" :subtitle="$playlist->description"
                        :cover="$playlist->cover_url" :art="$playlist->artwork" />
                @endforeach
            </div>
        </section>

        <section class="flex flex-col gap-3 md:gap-4">
            <x-section-header title="Recommended Artists" href="#" />
            <div class="{{ $rail }}">
                @foreach ($recommendedArtists as $artist)
                    <x-music-card circle :title="$artist->name" subtitle="Artist"
                        :cover="$artist->photo_url" :art="$artist->artwork" />
                @endforeach
            </div>
        </section>

        <section class="flex flex-col gap-3 md:gap-4">
            <x-section-header title="Recommended Music" eyebrow="Based on your recent listening" href="#" />
            <div class="{{ $rail }}">
                @foreach ($recommendedMusic as $album)
                    <x-music-card :title="$album->title" :subtitle="$album->artist->name"
                        :cover="$album->cover_url" :art="$album->artwork" />
                @endforeach
            </div>
        </section>
    </div>
@endsection
