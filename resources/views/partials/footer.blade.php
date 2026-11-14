@php
    $columns = [
        'Company' => ['About', 'Careers', 'For the Record'],
        'Communities' => ['For Artists', 'Developers', 'Advertising'],
        'Useful links' => ['Support', 'Web Player', 'Free Mobile App'],
    ];
@endphp

<footer class="mx-4 hidden pt-8 pb-10 md:mx-6 md:block">
    <div class="flex flex-wrap gap-6">
        @foreach ($columns as $heading => $links)
            <div class="flex w-[200px] flex-col gap-2.5">
                <h3 class="text-sm font-bold">{{ $heading }}</h3>
                @foreach ($links as $link)
                    <a href="#" class="text-sm text-text-secondary transition-colors hover:text-white hover:underline">{{ $link }}</a>
                @endforeach
            </div>
        @endforeach

        <div class="ml-auto flex gap-3">
            @foreach (['share-2' => 'Share', 'user' => 'Profile', 'music' => 'MoSing for Artists'] as $icon => $label)
                <a href="#" aria-label="{{ $label }}" class="flex size-10 items-center justify-center rounded-full bg-card text-white transition-colors hover:bg-card-hover">
                    <x-dynamic-component :component="'lucide-'.$icon" class="size-[18px]" />
                </a>
            @endforeach
        </div>
    </div>
    <div class="mt-6 h-px bg-border"></div>
    <p class="mt-6 text-[13px] text-text-secondary">© {{ now()->year }} MoSing Music</p>
</footer>
