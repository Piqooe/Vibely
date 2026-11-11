@props(['active' => false, 'href' => null])

@php
    $classes = [
        'inline-flex h-[30px] shrink-0 items-center rounded-full px-3.5 text-[13px] font-semibold whitespace-nowrap transition-colors',
        $active ? 'bg-accent text-black' : 'bg-card text-white hover:bg-card-hover',
    ];
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class($classes) }} @if ($active) aria-current="true" @endif>{{ $slot }}</a>
@else
    <button type="button" {{ $attributes->class($classes) }} aria-pressed="{{ $active ? 'true' : 'false' }}">{{ $slot }}</button>
@endif
