@props(['circle' => false])

<div {{ $attributes->class([
    'flex w-[140px] shrink-0 flex-col gap-2.5 rounded-lg md:w-auto md:bg-card md:p-3',
]) }} aria-hidden="true">
    @foreach ([
        ['aspect-square w-full bg-card-hover', $circle ? 'rounded-full' : 'rounded-md'],
        ['h-3.5 w-[75%] bg-skeleton', 'rounded'],
        ['h-3 w-[55%] bg-card-hover', 'rounded'],
    ] as [$shape, $radius])
        <div class="relative overflow-hidden {{ $shape }} {{ $radius }} {{ $circle && ! $loop->first ? 'mx-auto' : '' }}">
            <div class="absolute inset-0 motion-safe:animate-shimmer bg-linear-to-r from-transparent via-white/6 to-transparent"></div>
        </div>
    @endforeach
</div>
