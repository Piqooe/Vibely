@php($initials = \App\Support\Format::initials($currentUser->name))

<header data-topbar
    class="sticky top-0 z-30 hidden h-16 items-center justify-between gap-6 px-6 transition-colors duration-200 data-scrolled:bg-content/95 md:flex">
    <div class="flex gap-2">
        <button type="button" data-history="back" aria-label="Go back"
            class="flex size-8 items-center justify-center rounded-full bg-black/70 text-white transition hover:bg-black">
            <x-lucide-chevron-left class="size-[18px]" />
        </button>
        <button type="button" data-history="forward" aria-label="Go forward"
            class="flex size-8 items-center justify-center rounded-full bg-black/70 text-muted transition hover:bg-black hover:text-white">
            <x-lucide-chevron-right class="size-[18px]" />
        </button>
    </div>

    <div class="flex items-center gap-3">
        <button type="button" aria-label="Notifications"
            class="flex size-8 items-center justify-center rounded-full bg-black/70 text-white transition hover:scale-105 hover:bg-black">
            <x-lucide-bell class="size-4" />
        </button>
        <button type="button" aria-label="Account menu"
            class="flex h-8 items-center gap-2 rounded-full bg-black/70 py-0.5 pr-3 pl-0.5 transition hover:bg-black">
            @if ($currentUser->avatar_url ?? null)
                <img src="{{ $currentUser->avatar_url }}" alt="" class="size-7 rounded-full object-cover">
            @else
                <span class="flex size-7 items-center justify-center rounded-full bg-linear-to-br from-[#8B5CF6] to-[#1E1B4B] text-[11px] font-bold">{{ $initials }}</span>
            @endif
            <span class="text-sm font-semibold">{{ $currentUser->name }}</span>
            <x-lucide-chevron-down class="size-4 text-text-secondary" />
        </button>
    </div>
</header>
