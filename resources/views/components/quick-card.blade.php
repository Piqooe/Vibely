@props(['title', 'cover' => null, 'art' => null, 'href' => '#', 'playing' => false, 'liked' => false])

<article {{ $attributes->class([
    'group relative flex h-[52px] items-center gap-2.5 overflow-hidden rounded bg-card pr-2 transition-colors duration-150',
    'hover:bg-card-hover md:h-16 md:gap-3.5 md:rounded-md md:pr-3',
]) }}>
    @if ($liked)
        <x-liked-tile class="size-[52px] md:size-16" icon="size-[22px]" />
    @else
        <x-cover :src="$cover" :art="$art" :seed="$title" class="size-[52px] md:size-16" />
    @endif

    <a href="{{ $href }}" @class([
        'min-w-0 flex-1 truncate text-xs font-bold outline-none after:absolute after:inset-0 md:text-sm',
        'focus-visible:after:outline-2 focus-visible:after:-outline-offset-2 focus-visible:after:outline-accent',
        $playing ? 'text-accent' : 'text-white',
    ])>{{ $title }}</a>

    <div class="relative hidden h-9 w-9 shrink-0 items-center justify-center md:flex">
        @if ($playing)
            <x-equalizer class="transition-opacity duration-150 group-hover:opacity-0" />
        @endif
        <x-play-button size="sm" :icon="$playing ? 'pause' : 'play'" :label="($playing ? 'Pause ' : 'Play ').$title"
            class="shadow-play-sm absolute inset-0 z-10 opacity-0 duration-150 group-hover:opacity-100 focus-visible:opacity-100" />
    </div>
</article>
