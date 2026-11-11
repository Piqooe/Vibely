@props(['variant' => 'primary', 'icon' => null, 'href' => null, 'type' => 'button'])

@php
    $classes = [
        'inline-flex h-[39px] shrink-0 items-center justify-center gap-2 rounded-lg px-5 text-sm whitespace-nowrap transition',
        'focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-accent',
        'disabled:pointer-events-none disabled:bg-accent/35 disabled:text-black/50 disabled:border-transparent',
        match ($variant) {
            'primary' => 'bg-accent font-bold text-black hover:brightness-110 active:brightness-95',
            'secondary' => 'border border-outline font-semibold text-white hover:border-white',
            'dark' => 'bg-card font-semibold text-white hover:bg-card-hover',
            'danger' => 'bg-danger font-semibold text-white hover:brightness-110',
            default => 'font-semibold text-text-secondary hover:text-white',
        },
    ];
    $iconClass = 'size-4 '.($variant === 'primary' && $icon === 'play' ? 'fill-current' : '');
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }}>
        @if ($icon) <x-dynamic-component :component="'lucide-'.$icon" :class="$iconClass" /> @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class($classes) }}>
        @if ($icon) <x-dynamic-component :component="'lucide-'.$icon" :class="$iconClass" /> @endif
        {{ $slot }}
    </button>
@endif
