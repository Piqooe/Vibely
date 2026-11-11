@props(['icon' => 'music', 'title', 'message' => null])

<div {{ $attributes->class(['flex flex-col items-center rounded-[10px] bg-content p-8 text-center']) }}>
    <div class="flex size-[88px] items-center justify-center rounded-full bg-card">
        <x-dynamic-component :component="'lucide-'.$icon" class="size-9 text-text-secondary" />
    </div>
    <h3 class="mt-3.5 text-2xl font-bold">{{ $title }}</h3>
    @if ($message)
        <p class="mt-3.5 max-w-xs text-[15px] leading-[22px] text-text-secondary">{{ $message }}</p>
    @endif
    @if ($slot->isNotEmpty())
        <div class="mt-[18px]">{{ $slot }}</div>
    @endif
</div>
