@props(['title', 'eyebrow' => null, 'href' => null, 'linkText' => 'Show all'])

<div {{ $attributes->class(['flex items-end justify-between gap-4']) }}>
    <div class="flex min-w-0 flex-col gap-0.5 md:gap-1">
        @if ($eyebrow)
            <p class="text-xs text-text-secondary md:text-[13px]">{{ $eyebrow }}</p>
        @endif
        <h2 class="truncate text-xl font-bold tracking-[-0.3px] md:text-[22px]">
            @if ($href)
                <a href="{{ $href }}" class="hover:underline">{{ $title }}</a>
            @else
                {{ $title }}
            @endif
        </h2>
    </div>
    @if ($href)
        <a href="{{ $href }}" class="shrink-0 text-xs font-semibold text-text-secondary transition-colors hover:text-white hover:underline md:text-[13px]">{{ $linkText }}</a>
    @endif
</div>
