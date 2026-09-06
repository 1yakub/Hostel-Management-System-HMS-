<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <title>{{ config('hms.hostel_name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="32x32">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="preload" href="{{ asset('fonts/figtree-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-chalk text-ink antialiased">
    <div class="mx-auto grid min-h-screen max-w-6xl md:grid-cols-2">
        <div class="flex flex-col px-5 py-8 md:py-12">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('brand/mark-fern.svg') }}" alt="" width="40" height="36" class="h-9 w-10">
                <span class="text-lg font-semibold tracking-tight">{{ config('hms.hostel_name') }}</span>
            </a>
            <div class="my-auto w-full max-w-md py-12">
                {{ $slot }}
            </div>
            @if (config('hms.demo_mode'))
                <div class="rounded-control border border-rule bg-chalk-2 p-4 text-sm text-slate">
                    <p class="font-medium text-ink">Demo accounts</p>
                    <p class="mt-1">Desk staff: staff@example.com &middot; Guest: guest@example.com &middot; password: <span class="font-mono">{{ config('hms.demo_password') }}</span></p>
                    <p class="mt-1">The database resets every night.</p>
                </div>
            @endif
        </div>
        <div class="hidden md:block md:py-12 md:pr-5">
            <img src="{{ asset('images/room-private.webp') }}" width="1024" height="768" alt="" class="h-full w-full rounded-photo object-cover" loading="lazy">
        </div>
    </div>
</body>
</html>
