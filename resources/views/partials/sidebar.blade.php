@php
    $nav = [
        ['label' => 'Home', 'icon' => 'house', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Search', 'icon' => 'search', 'href' => '#', 'active' => false],
    ];
    $libraryFilters = ['Playlists', 'Artists', 'Albums'];
@endphp

<aside class="hidden w-[72px] shrink-0 flex-col overflow-hidden rounded-lg bg-sidebar md:flex lg:w-72" aria-label="Sidebar">

    <div class="flex h-full flex-col items-center gap-2.5 overflow-y-auto px-3 py-5 scrollbar-none lg:hidden">
        <a href="{{ route('home') }}" class="mb-3 flex size-9 shrink-0 items-center justify-center rounded-lg bg-accent" aria-label="MoSing">
            <x-lucide-audio-waveform class="size-5 text-black" />
        </a>

        @foreach ($nav as $item)
            <a href="{{ $item['href'] }}" title="{{ $item['label'] }}" aria-label="{{ $item['label'] }}"
                @if ($item['active']) aria-current="page" @endif
                @class([
                    'flex size-12 shrink-0 items-center justify-center rounded-lg transition-colors',
                    $item['active'] ? 'bg-card text-accent' : 'text-text-secondary hover:bg-card hover:text-white',
                ])>
                <x-dynamic-component :component="'lucide-'.$item['icon']" class="size-6" />
            </a>
        @endforeach
        <a href="#" title="Your Library" aria-label="Your Library"
            class="flex size-12 shrink-0 items-center justify-center rounded-lg text-text-secondary transition-colors hover:bg-card hover:text-white">
            <x-lucide-library class="size-6" />
        </a>

        <div class="h-px w-12 shrink-0 bg-border"></div>

        @foreach ($library as $item)
            <a href="#" title="{{ $item->title }}" aria-label="{{ $item->title }}" class="shrink-0 transition-opacity hover:opacity-80">
                @if ($item->type === 'liked')
                    <x-liked-tile class="size-12 rounded" />
                @else
                    <x-cover :src="$item->cover_url" :art="$item->artwork" :seed="$item->title" :artist="$item->type === 'artist'"
                        @class(['size-12', $item->type === 'artist' ? 'rounded-full' : 'rounded']) />
                @endif
            </a>
        @endforeach
    </div>

    <div class="hidden h-full flex-col gap-0.5 px-3 pt-5 pb-4 lg:flex">
        <a href="{{ route('home') }}" class="flex items-center gap-2.5 px-3 pt-1 pb-5">
            <span class="flex size-[33px] items-center justify-center rounded-lg bg-accent">
                <x-lucide-audio-waveform class="size-5 text-black" />
            </span>
            <span class="text-[22px] font-bold tracking-[-0.4px]">MoSing</span>
        </a>

        <nav class="flex flex-col gap-0.5" aria-label="Main">
            @foreach ($nav as $item)
                <a href="{{ $item['href'] }}" @if ($item['active']) aria-current="page" @endif
                    @class([
                        'group flex h-[42px] items-center gap-4 rounded-md px-3 text-[15px] transition-colors',
                        $item['active'] ? 'bg-card font-bold text-white' : 'font-semibold text-text-secondary hover:text-white',
                    ])>
                    <x-dynamic-component :component="'lucide-'.$item['icon']"
                        @class(['size-[22px]', $item['active'] ? 'text-accent' : '']) />
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="my-2 h-px shrink-0 bg-border"></div>

        <div class="flex h-[42px] items-center justify-between px-3">
            <a href="#" class="flex items-center gap-4 text-[15px] font-semibold text-text-secondary transition-colors hover:text-white">
                <x-lucide-library class="size-[22px]" />
                Your Library
            </a>
            <button type="button" aria-label="Create playlist or folder"
                class="flex size-[30px] items-center justify-center rounded-full bg-card text-text-secondary transition-colors hover:bg-card-hover hover:text-white">
                <x-lucide-plus class="size-4" />
            </button>
        </div>

        <div class="flex gap-2 px-2 pt-1 pb-2">
            @foreach ($libraryFilters as $filter)
                <x-chip :active="$loop->first">{{ $filter }}</x-chip>
            @endforeach
        </div>

        <div class="-mx-1 flex min-h-0 flex-1 flex-col gap-0.5 overflow-y-auto px-1">
            <button type="button" class="flex shrink-0 items-center gap-3 rounded-md px-2 py-1.5 text-left transition-colors hover:bg-card">
                <span class="flex size-12 items-center justify-center rounded border border-border bg-card">
                    <x-lucide-plus class="size-[22px]" />
                </span>
                <span class="text-sm font-semibold">Create Playlist</span>
            </button>

            @foreach ($library as $item)
                <a href="#" class="flex shrink-0 items-center gap-3 rounded-md px-2 py-1.5 transition-colors hover:bg-card">
                    @if ($item->type === 'liked')
                        <x-liked-tile class="size-12 rounded" />
                    @else
                        <x-cover :src="$item->cover_url" :art="$item->artwork" :seed="$item->title" :artist="$item->type === 'artist'"
                            @class(['size-12', $item->type === 'artist' ? 'rounded-full' : 'rounded']) />
                    @endif
                    <span class="flex min-w-0 flex-1 flex-col gap-[3px]">
                        <span @class(['truncate text-sm font-semibold', $item->is_playing ? 'text-accent' : 'text-white'])>{{ $item->title }}</span>
                        <span class="truncate text-xs text-text-secondary">{{ $item->subtitle }}</span>
                    </span>
                    @if ($item->is_playing)
                        <x-lucide-volume-2 class="size-4 shrink-0 text-accent" aria-label="Now playing" />
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</aside>
