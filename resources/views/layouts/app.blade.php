<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">
    <title>{{ isset($title) ? $title.' | ' : '' }}{{ config('app.name', 'HMS') }} back office</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preload" href="{{ asset('fonts/bricolage-grotesque-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-chalk-2 text-ink antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:rounded-control focus:bg-ink focus:px-4 focus:py-2 focus:text-chalk">Skip to content</a>

    @include('layouts.navigation')

    @isset($header)
        <header class="border-b border-rule bg-chalk">
            <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-5 py-6">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main id="main" class="mx-auto max-w-6xl px-5 py-8">
        @if (session('success') || session('error') || session('status'))
            <div role="status" class="mb-6 rounded-control border px-4 py-3 text-sm {{ session('error') ? 'border-danger/30 bg-red-50 text-danger' : 'border-fern-100 bg-fern-50 text-fern-700' }}">
                {{ session('success') ?? session('error') ?? session('status') }}
            </div>
        @endif
        {{ $slot }}
    </main>
</body>
</html>
