@php
    $tabs = [
        ['label' => 'Home', 'icon' => 'house', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Search', 'icon' => 'search', 'href' => '#', 'active' => false],
        ['label' => 'Library', 'icon' => 'library', 'href' => '#', 'active' => false],
        ['label' => 'Liked', 'icon' => 'heart', 'href' => '#', 'active' => false],
    ];
@endphp

<nav class="shrink-0 border-t border-border bg-linear-to-b from-bg/90 to-black px-2 pt-2.5 pb-[max(6px,env(safe-area-inset-bottom))] md:hidden" aria-label="Main">
    <ul class="flex">
        @foreach ($tabs as $tab)
            <li class="flex-1">
                <a href="{{ $tab['href'] }}" @if ($tab['active']) aria-current="page" @endif
                    @class([
                        'flex flex-col items-center gap-1 text-[11px] transition-colors',
                        $tab['active'] ? 'font-semibold text-white' : 'text-text-secondary hover:text-white',
                    ])>
                    <x-dynamic-component :component="'lucide-'.$tab['icon']" class="size-6" />
                    {{ $tab['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
