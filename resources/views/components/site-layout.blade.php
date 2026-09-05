@props(["title" => null, "description" => null])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('hms.hostel_name') }}</title>
    <meta name="description" content="{{ $description ?? config('hms.hostel_name').'. '.config('hms.tagline').' Dorm beds, private doubles and a family room in '.config('hms.city').'. Check live availability and request a booking.' }}">
    <meta property="og:title" content="{{ $title ?? config('hms.hostel_name') }}">
    <meta property="og:description" content="{{ config('hms.tagline') }}">
    <meta property="og:image" content="{{ asset('images/hero-common-room.webp') }}">
    <meta name="theme-color" content="#fbfaf7">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preload" href="{{ asset('fonts/bricolage-grotesque-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-chalk text-ink antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-control focus:bg-ink focus:px-4 focus:py-2 focus:text-chalk">Skip to content</a>

    @if (config('hms.demo_mode'))
        <div class="border-b border-rule bg-chalk-2 text-sm text-slate">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-5 py-2">
                <p>Demo: a fictional hostel run on the Hostel Management System. Bookings are requests, nothing is charged.</p>
                <a href="{{ route('login') }}" class="shrink-0 underline decoration-rule underline-offset-4 hover:decoration-fern-500">Staff demo login</a>
            </div>
        </div>
    @endif

    <header class="border-b border-rule bg-chalk/95 backdrop-blur supports-[backdrop-filter]:bg-chalk/80 sticky top-0 z-40" x-data="{ open: false }">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-4">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span aria-hidden="true" class="grid size-9 place-items-center rounded-control bg-fern-500 text-chalk font-semibold">{{ mb_substr(config('hms.hostel_name'), 0, 1) }}</span>
                <span class="text-lg font-semibold tracking-tight">{{ config('hms.hostel_name') }}</span>
            </a>
            <nav class="hidden items-center gap-7 text-[0.95rem] md:flex" aria-label="Main">
                <a href="{{ url('/#rooms') }}" class="hover:text-fern-600">Rooms</a>
                <a href="{{ url('/#stay') }}" class="hover:text-fern-600">The house</a>
                <a href="{{ url('/#faq') }}" class="hover:text-fern-600">Questions</a>
                @auth
                    <a href="{{ auth()->user()->is_staff ? route('staff.dashboard') : route('dashboard') }}" class="hover:text-fern-600">{{ auth()->user()->is_staff ? 'Back office' : 'My bookings' }}</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-fern-600">Sign in</a>
                @endauth
                <a href="{{ url('/#book') }}" class="rounded-control bg-ink px-4 py-2 font-medium text-chalk hover:bg-ink-2">Check availability</a>
            </nav>
            <button type="button" class="md:hidden rounded-control border border-rule p-2" @click="open = !open" :aria-expanded="open" aria-controls="mobile-nav" aria-label="Menu">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path x-show="!open" d="M4 7h16M4 12h16M4 17h16" /><path x-show="open" x-cloak d="M6 6l12 12M18 6L6 18" /></svg>
            </button>
        </div>
        <nav id="mobile-nav" x-show="open" x-cloak class="border-t border-rule px-5 py-4 md:hidden" aria-label="Main mobile">
            <div class="grid gap-3 text-base">
                <a href="{{ url('/#rooms') }}" @click="open = false">Rooms</a>
                <a href="{{ url('/#stay') }}" @click="open = false">The house</a>
                <a href="{{ url('/#faq') }}" @click="open = false">Questions</a>
                @auth
                    <a href="{{ auth()->user()->is_staff ? route('staff.dashboard') : route('dashboard') }}">{{ auth()->user()->is_staff ? 'Back office' : 'My bookings' }}</a>
                @else
                    <a href="{{ route('login') }}">Sign in</a>
                @endauth
                <a href="{{ url('/#book') }}" class="mt-2 rounded-control bg-ink px-4 py-3 text-center font-medium text-chalk" @click="open = false">Check availability</a>
            </div>
        </nav>
    </header>

    @if (session('success') || session('error'))
        <div class="mx-auto max-w-6xl px-5 pt-5">
            <div role="status" class="rounded-control border px-4 py-3 text-sm {{ session('error') ? 'border-danger/30 bg-red-50 text-danger' : 'border-fern-100 bg-fern-50 text-fern-700' }}">
                {{ session('success') ?? session('error') }}
            </div>
        </div>
    @endif

    <main id="main">
        {{ $slot }}
    </main>

    <footer class="mt-24 border-t border-rule">
        <div class="mx-auto grid max-w-6xl gap-10 px-5 py-14 md:grid-cols-3">
            <div>
                <p class="text-lg font-semibold">{{ config('hms.hostel_name') }}</p>
                <p class="mt-2 max-w-xs text-slate">{{ config('hms.tagline') }}</p>
            </div>
            <div class="text-slate">
                <p class="font-medium text-ink">Find us</p>
                <p class="mt-2">{{ config('hms.address_line') }}<br>{{ config('hms.city') }}</p>
                <p class="mt-2"><a href="tel:{{ preg_replace('/\s+/', '', config('hms.phone')) }}" class="hover:text-fern-600">{{ config('hms.phone') }}</a><br><a href="mailto:{{ config('hms.email') }}" class="hover:text-fern-600">{{ config('hms.email') }}</a></p>
            </div>
            <div class="text-slate">
                <p class="font-medium text-ink">Hours</p>
                <p class="mt-2">Check in from {{ config('hms.check_in') }}<br>Check out by {{ config('hms.check_out') }}<br>Desk open 8:00 AM to 11:00 PM</p>
            </div>
        </div>
        <div class="border-t border-rule">
            <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-5 py-5 text-sm text-slate-2">
                <p>{{ config('hms.hostel_name') }} is a demo of the Hostel Management System, an open source Laravel application.</p>
                <a href="https://github.com/1yakub/Hostel-Management-System-HMS-" class="hover:text-fern-600" rel="noopener">Source on GitHub</a>
            </div>
        </div>
    </footer>

    {{ $scripts ?? "" }}
</body>
</html>
