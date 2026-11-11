@props([
    'title',
    'subtitle' => null,
    'cover' => null,
    'art' => null,
    'href' => '#',
    'circle' => false,
    'label' => true,
])

<article {{ $attributes->class([
    'group relative flex shrink-0 flex-col gap-1.5 rounded-lg transition-colors duration-200',
    'w-[140px] md:w-auto md:p-3',
    $circle ? 'md:hover:bg-card' : 'md:bg-card md:hover:bg-card-hover',
]) }}>
    <div class="relative">
        <x-cover :src="$cover" :art="$art" :seed="$title" :artist="$circle"
            :label="$circle || $label === false ? null : ($label === true ? $title : $label)"
            @class(['aspect-square w-full', $circle ? 'rounded-full' : 'rounded-md']) />

        <x-play-button size="md" :label="'Play '.$title"
            class="shadow-play absolute right-2 bottom-2 z-10 hidden translate-y-2 opacity-0 duration-200 ease-out group-hover:translate-y-0 group-hover:opacity-100 focus-visible:translate-y-0 focus-visible:opacity-100 md:inline-flex" />
    </div>

    <a href="{{ $href }}" @class([
        'mt-0 truncate text-[13px] font-semibold text-white outline-none after:absolute after:inset-0 after:rounded-lg md:text-[15px]',
        'focus-visible:after:outline-2 focus-visible:after:outline-accent',
        'text-center' => $circle,
    ])>{{ $title }}</a>

    @if ($subtitle)
        <p @class([
            'line-clamp-2 text-xs leading-[15px] text-text-secondary md:text-[13px] md:leading-[18px]',
            'text-center' => $circle,
        ])>{{ $subtitle }}</p>
    @endif
</article>
