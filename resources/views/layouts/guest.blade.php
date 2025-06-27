<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 z-0">
            <div
                class="absolute -left-48 -top-48 w-96 h-96 rounded-full bg-luxury-200/30 dark:bg-luxury-900/30 blur-3xl">
            </div>
            <div
                class="absolute -right-48 -bottom-48 w-96 h-96 rounded-full bg-accent-200/30 dark:bg-accent-900/30 blur-3xl">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-white/5 dark:bg-black/5 backdrop-blur-3xl">
            </div>
        </div>

        <div class="z-10">
            <a href="/" class="font-serif text-2xl font-bold text-luxury-800 dark:text-luxury-200">
                {{ config('app.name') }}
            </a>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>

        <div class="z-10 mt-8 text-center text-sm text-luxury-600/60 dark:text-luxury-400/60">
            <p>© {{ date('Y') }} Luxury Hostel. All rights reserved.</p>
        </div>
    </div>
</body>

</html>