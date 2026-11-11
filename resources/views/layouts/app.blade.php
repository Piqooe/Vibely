<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#121212">
    <title>@hasSection('title') @yield('title') · Vibely @else Vibely – Music Streaming @endif</title>

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="overflow-hidden bg-bg font-sans text-white antialiased">
    <div class="flex h-dvh flex-col">
        <div class="flex min-h-0 flex-1 md:gap-2 md:p-2">
            @include('partials.sidebar')

            <main id="main" data-scroll-root
                class="relative isolate min-w-0 flex-1 overflow-x-hidden overflow-y-auto bg-bg md:rounded-lg md:bg-content">
                <div class="pointer-events-none absolute inset-x-0 top-0 -z-10 h-[260px] bg-linear-to-b from-accent/18 to-transparent md:h-[185px] md:from-accent/22" aria-hidden="true"></div>

                @include('partials.topbar')

                @yield('content')

                @include('partials.footer')
            </main>
        </div>

        @include('partials.mini-player')
        @include('partials.player')
        @include('partials.bottom-nav')
    </div>
</body>
</html>
