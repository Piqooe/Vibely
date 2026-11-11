@php($progress = $nowPlaying->duration ? round($nowPlaying->position / $nowPlaying->duration * 100, 2) : 0)

<div class="shrink-0 bg-bg px-2 pb-1.5 md:hidden">
    <div class="relative flex h-[58px] items-center gap-3 rounded-lg bg-mini-player py-2 pr-3 pl-2 shadow-[0_4px_16px_rgb(0_0_0/0.6)]">
        <x-cover :src="$nowPlaying->cover_url" :art="$nowPlaying->artwork" :seed="$nowPlaying->album->title" class="size-10 rounded" />
        <a href="#" class="flex min-w-0 flex-1 flex-col gap-0.5">
            <span class="truncate text-[13px] font-semibold">{{ $nowPlaying->title }}</span>
            <span class="truncate text-xs text-text-secondary">{{ $nowPlaying->artist->name }}</span>
        </a>
        <button type="button" aria-label="Connect to a device" class="p-1.5 text-text-secondary"><x-lucide-monitor-speaker class="size-5" /></button>
        <button type="button" aria-label="Remove from Liked Songs" aria-pressed="true" class="p-1.5 text-accent"><x-lucide-heart class="size-5 fill-current" /></button>
        <button type="button" aria-label="Pause" class="p-1 text-white"><x-lucide-pause class="size-[22px] fill-current" /></button>

        <div class="absolute inset-x-2 bottom-0.5 h-0.5 rounded-full bg-white/20" aria-hidden="true">
            <div class="h-full rounded-full bg-accent" style="width: {{ $progress }}%"></div>
        </div>
    </div>
</div>
