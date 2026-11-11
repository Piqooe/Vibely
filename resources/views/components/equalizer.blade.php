@props(['animated' => true])

<span {{ $attributes->class(['inline-flex h-3.5 items-end gap-0.5 text-accent']) }} role="img" aria-label="Now playing">
    @foreach ([[8, '0s'], [14, '-.3s'], [10, '-.6s'], [5, '-.45s']] as [$h, $delay])
        <span class="w-[3px] origin-bottom rounded-[1px] bg-current {{ $animated ? 'motion-safe:animate-eq' : '' }}"
            style="height: {{ $h }}px; animation-delay: {{ $delay }}"></span>
    @endforeach
</span>
