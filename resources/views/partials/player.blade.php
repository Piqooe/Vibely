@php
    use App\Support\Format;
    $progress = $nowPlaying->duration ? round($nowPlaying->position / $nowPlaying->duration * 100, 2) : 0;
    $volume = 70;
    $iconBtn = 'flex items-center justify-center text-text-secondary transition-colors hover:text-white';
@endphp

<footer class="hidden h-[88px] shrink-0 items-center justify-between gap-4 border-t border-border bg-sidebar px-4 md:flex" aria-label="Now playing">
    <div class="flex w-[200px] min-w-0 items-center gap-3.5 lg:w-[300px]">
        <x-cover :src="$nowPlaying->cover_url" :art="$nowPlaying->artwork" :seed="$nowPlaying->album->title" class="size-14 rounded" />
        <div class="flex min-w-0 flex-col gap-1">
            <a href="#" class="truncate text-sm font-semibold hover:underline">{{ $nowPlaying->title }}</a>
            <a href="#" class="truncate text-xs text-text-secondary hover:text-white hover:underline">{{ $nowPlaying->artist->name }}</a>
        </div>
        <button type="button" aria-label="Remove from Liked Songs" aria-pressed="true" class="ml-1 shrink-0 text-accent transition hover:scale-105">
            <x-lucide-heart class="size-[18px] fill-current" />
        </button>
    </div>

    <div class="flex max-w-[552px] min-w-0 flex-1 flex-col items-center gap-2">
        <div class="flex items-center gap-6">
            <button type="button" aria-label="Shuffle" aria-pressed="true" class="text-accent transition hover:brightness-125">
                <x-lucide-shuffle class="size-[18px]" />
            </button>
            <button type="button" aria-label="Previous" class="text-white transition hover:scale-105">
                <x-lucide-skip-back class="size-[18px] fill-current" />
            </button>
            <x-play-button size="sm" label="Play" />
            <button type="button" aria-label="Next" class="text-white transition hover:scale-105">
                <x-lucide-skip-forward class="size-[18px] fill-current" />
            </button>
            <button type="button" aria-label="Repeat" aria-pressed="false" class="{{ $iconBtn }}">
                <x-lucide-repeat class="size-[18px]" />
            </button>
        </div>

        <div class="flex w-full items-center gap-2.5">
            <span class="w-9 shrink-0 text-xs text-text-secondary tabular-nums">{{ Format::duration($nowPlaying->position) }}</span>
            <div class="group relative h-1 flex-1 rounded-full bg-track" role="slider" aria-label="Seek"
                aria-valuemin="0" aria-valuemax="{{ $nowPlaying->duration }}" aria-valuenow="{{ $nowPlaying->position }}"
                aria-valuetext="{{ Format::duration($nowPlaying->position) }} of {{ Format::duration($nowPlaying->duration) }}" tabindex="0">
                <div class="absolute inset-y-0 left-0 rounded-full bg-accent" style="width: {{ $progress }}%"></div>
                <div class="absolute top-1/2 size-3 -translate-x-1/2 -translate-y-1/2 rounded-full bg-white shadow-[0_1px_4px_rgb(0_0_0/0.4)]" style="left: {{ $progress }}%"></div>
            </div>
            <span class="w-9 shrink-0 text-right text-xs text-text-secondary tabular-nums">{{ Format::duration($nowPlaying->duration) }}</span>
        </div>
    </div>

    <div class="flex w-[200px] items-center justify-end gap-4 lg:w-[300px]">
        <button type="button" aria-label="Lyrics" class="{{ $iconBtn }} hidden lg:flex"><x-lucide-mic-vocal class="size-[18px]" /></button>
        <button type="button" aria-label="Queue" class="{{ $iconBtn }}"><x-lucide-list-music class="size-[18px]" /></button>
        <button type="button" aria-label="Connect to a device" class="{{ $iconBtn }} hidden lg:flex"><x-lucide-monitor-speaker class="size-[18px]" /></button>
        <div class="flex items-center gap-2">
            <button type="button" aria-label="Mute" class="{{ $iconBtn }}"><x-lucide-volume-2 class="size-[18px]" /></button>
            <div class="relative hidden h-1 w-24 rounded-full bg-track lg:block" role="slider" aria-label="Volume"
                aria-valuemin="0" aria-valuemax="100" aria-valuenow="{{ $volume }}" tabindex="0">
                <div class="absolute inset-y-0 left-0 rounded-full bg-white" style="width: {{ $volume }}%"></div>
            </div>
        </div>
        <button type="button" aria-label="Full screen" class="{{ $iconBtn }} hidden lg:flex"><x-lucide-maximize-2 class="size-4" /></button>
    </div>
</footer>
