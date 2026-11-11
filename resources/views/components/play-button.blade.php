@props(['size' => 'md', 'icon' => 'play', 'label' => 'Play'])

@php
    [$box, $ico, $shift] = match ($size) {
        'sm' => ['size-9', 'size-[15px]', 'pl-0.5'],
        'lg' => ['size-12', 'size-5', 'pl-[3px]'],
        'xl' => ['size-14', 'size-6', 'pl-[3px]'],
        default => ['size-11', 'size-[18px]', 'pl-[3px]'],
    };
@endphp

<button type="button" aria-label="{{ $label }}"
    {{ $attributes->class([
        'inline-flex shrink-0 items-center justify-center rounded-full bg-accent text-black transition hover:scale-105 hover:brightness-110 active:scale-95',
        $box,
        $icon === 'play' ? $shift : '',
    ]) }}>
    <x-dynamic-component :component="'lucide-'.$icon" class="{{ $ico }} fill-current" />
</button>
