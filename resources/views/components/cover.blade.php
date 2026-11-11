@props([
    'src' => null,
    'art' => null,
    'seed' => '',
    'label' => null,
    'labelSize' => 'text-[10px]',
    'artist' => false,
    'alt' => '',
])

@php
    $a = \App\Support\Artwork::resolve($art, $seed);
    $accent = $a['accent'];
    $bg = $artist
        ? "radial-gradient(ellipse 90% 90% at 35% 30%, {$a['accent']} 0%, {$a['dark']} 100%)"
        : "linear-gradient(135deg, {$a['dark']} 0%, {$a['accent']}b3 100%)";
@endphp

<div {{ $attributes->class(['relative shrink-0 overflow-hidden bg-card']) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $alt ?: $seed }}" loading="lazy" class="absolute inset-0 size-full object-cover">
    @else
        <div class="absolute inset-0" style="background: {{ $bg }}" aria-hidden="true">
            <svg viewBox="0 0 100 100" class="absolute inset-0 size-full" preserveAspectRatio="none">
                @if ($artist)
                    <circle cx="50" cy="39" r="17" fill="#fff" fill-opacity=".18" />
                    <ellipse cx="50" cy="92" rx="37" ry="30" fill="#fff" fill-opacity=".14" />
                @elseif ($a['pattern'] === 'orb')
                    <circle cx="73" cy="27" r="39" fill="{{ $accent }}" fill-opacity=".8" />
                    <circle cx="25" cy="73" r="15" fill="#fff" fill-opacity=".2" />
                @elseif ($a['pattern'] === 'bands')
                    @foreach ([52 => .9, 64 => .7, 76 => .5, 88 => .3] as $y => $o)
                        <rect x="0" y="{{ $y }}" width="100" height="6" fill="{{ $accent }}" fill-opacity="{{ $o }}" />
                    @endforeach
                    <circle cx="50" cy="34" r="18" fill="#fff" fill-opacity=".9" />
                @elseif ($a['pattern'] === 'rings')
                    @foreach ([12.5, 23.5, 34.5, 45.5] as $r)
                        <circle cx="62" cy="42" r="{{ $r }}" fill="none" stroke="#fff" stroke-opacity=".25" stroke-width="1.1" />
                    @endforeach
                    <circle cx="62" cy="42" r="8" fill="{{ $accent }}" />
                @else
                    <ellipse cx="50" cy="107" rx="55" ry="45" fill="{{ $accent }}" fill-opacity=".85" />
                    <line x1="0" y1="60" x2="100" y2="60" stroke="#fff" stroke-opacity=".35" stroke-width="1" vector-effect="non-scaling-stroke" />
                    <circle cx="77" cy="23" r="9" fill="#fff" fill-opacity=".85" />
                @endif
            </svg>
            @if ($label)
                <span class="absolute top-[8%] left-[8%] max-w-[80%] font-bold tracking-[0.6px] text-white/90 uppercase leading-tight {{ $labelSize }}">{{ $label }}</span>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
