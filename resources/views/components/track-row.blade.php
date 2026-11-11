@props(['song', 'index' => 1, 'playing' => false, 'meta' => null])

@php
    $grid = 'grid-cols-[minmax(0,1fr)_32px_18px] md:grid-cols-[32px_minmax(0,1fr)_minmax(0,180px)_32px_56px_18px] xl:grid-cols-[32px_minmax(0,1fr)_240px_140px_32px_56px_18px]';
    $liked = (bool) ($song->is_liked ?? false);
@endphp

<div {{ $attributes->class([
    'group grid h-14 items-center gap-3 rounded-md px-2 transition-colors duration-150 md:gap-4 md:px-4',
    $grid,
    $playing ? 'bg-accent/8 hover:bg-accent/12' : 'hover:bg-card-hover',
]) }} @if ($playing) aria-current="true" @endif>
    <div class="relative hidden h-10 items-center justify-center md:flex">
        @if ($playing)
            <x-equalizer class="group-hover:hidden" />
            <button type="button" aria-label="Pause {{ $song->title }}" class="hidden text-white group-hover:block">
                <x-lucide-pause class="size-3.5 fill-current" />
            </button>
        @else
            <span class="text-[15px] text-text-secondary tabular-nums group-hover:hidden">{{ $index }}</span>
            <button type="button" aria-label="Play {{ $song->title }}" class="hidden text-white group-hover:block">
                <x-lucide-play class="size-3.5 fill-current" />
            </button>
        @endif
    </div>

    <div class="flex min-w-0 items-center gap-3">
        <x-cover :src="$song->cover_url" :art="$song->artwork" :seed="$song->album->title ?? $song->title" class="size-10 rounded" />
        <div class="flex min-w-0 flex-col gap-1">
            <a href="#" @class(['truncate text-[15px] leading-[18px] hover:underline', $playing ? 'text-accent' : 'text-white'])>{{ $song->title }}</a>
            <a href="#" class="truncate text-[13px] leading-4 text-text-secondary group-hover:text-white hover:underline">{{ $song->artist->name }}</a>
        </div>
    </div>

    <a href="#" class="hidden truncate text-sm text-text-secondary group-hover:text-white hover:underline md:block">{{ $song->album->title }}</a>

    <span class="hidden truncate text-sm text-text-secondary tabular-nums xl:block">{{ $meta ?? \App\Support\Format::plays($song->plays) }}</span>

    <button type="button" aria-label="{{ $liked ? 'Remove from' : 'Save to' }} Liked Songs" aria-pressed="{{ $liked ? 'true' : 'false' }}"
        @class([
            'flex size-8 items-center justify-center transition hover:scale-105',
            $liked ? 'text-accent' : 'text-text-secondary opacity-0 group-hover:opacity-100 focus-visible:opacity-100 hover:text-white',
        ])>
        <x-lucide-heart @class(['size-[18px]', 'fill-current' => $liked]) />
    </button>

    <span class="hidden text-sm text-text-secondary tabular-nums md:block">{{ \App\Support\Format::duration($song->duration) }}</span>

    <button type="button" aria-label="More options for {{ $song->title }}"
        class="flex size-[18px] items-center justify-center text-text-secondary transition-opacity hover:text-white md:text-white md:opacity-0 md:group-hover:opacity-100 md:focus-visible:opacity-100">
        <x-lucide-ellipsis class="size-[18px]" />
    </button>
</div>
