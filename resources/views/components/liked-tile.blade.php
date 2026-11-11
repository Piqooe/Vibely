@props(['icon' => 'size-5'])

<div {{ $attributes->class(['flex shrink-0 items-center justify-center bg-linear-to-br from-liked-from to-accent']) }}>
    <x-lucide-heart class="{{ $icon }} fill-white text-white" />
</div>
