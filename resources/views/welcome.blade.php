<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} - Hostel Management System | Laravel Demo</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Professional hostel management system built with Laravel 11.x. Live demo featuring room booking, guest management, and payment processing. Modern HMS solution.">
    <meta name="keywords"
        content="hostel management system, laravel, booking system, room management, demo, HMS, hotel management">
    <meta name="author" content="Md Yakub Hossain">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://hms.yakub.website/">
    <meta property="og:title" content="HMS - Hostel Management System | Laravel Demo">
    <meta property="og:description"
        content="Professional hostel management system built with Laravel 11.x. Live demo featuring room booking and guest management.">
    <meta property="og:image" content="https://hms.yakub.website/favicon.svg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://hms.yakub.website/">
    <meta property="twitter:title" content="HMS - Hostel Management System | Laravel Demo">
    <meta property="twitter:description"
        content="Professional hostel management system built with Laravel 11.x. Live demo featuring room booking and guest management.">
    <meta property="twitter:image" content="https://hms.yakub.website/favicon.svg">

    <!-- Canonical URL -->
    <link rel="canonical" href="https://hms.yakub.website/">

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

    <!-- Custom Styles -->
    <style>
        .pattern-dots {
            background-image:
                radial-gradient(#A47E62 0.85px, transparent 0.85px),
                radial-gradient(#A47E62 0.85px, transparent 0.85px);
            background-size: 34px 34px;
            background-position: 0 0, 17px 17px;
            opacity: 0.07;
        }

        .gradient-overlay {
            background: linear-gradient(135deg,
                    rgba(164, 126, 98, 0.15) 0%,
                    rgba(164, 126, 98, 0.05) 50%,
                    transparent 100%);
        }

        .hero-gradient {
            background: linear-gradient(to right,
                    rgba(255, 255, 255, 0.9) 0%,
                    rgba(255, 255, 255, 0.8) 50%,
                    rgba(255, 255, 255, 0) 100%);
        }

        .dark .hero-gradient {
            background: linear-gradient(to right,
                    rgba(17, 24, 39, 0.9) 0%,
                    rgba(17, 24, 39, 0.8) 50%,
                    rgba(17, 24, 39, 0) 100%);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .clip-diagonal {
            clip-path: polygon(0 0, 100% 0, 100% 85%, 0 100%);
        }
    </style>

    <!-- Dark Mode Script -->
    <script>
        // Set dark mode as default if no preference is stored
        if (!('theme' in localStorage)) {
            localStorage.setItem('theme', 'dark');
        }

        if (localStorage.theme === 'dark' || (!('theme' in localStorage))) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="antialiased">
    <div class="relative min-h-screen bg-luxury-50 dark:bg-gray-900">
        <!-- Background Pattern -->
        <div class="absolute inset-0 pattern-dots pointer-events-none"></div>
        <div class="absolute inset-0 gradient-overlay pointer-events-none"></div>

        <!-- Hero Section with Dynamic Background -->
        <div class="relative min-h-screen">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                    alt="Luxury Hotel" class="object-cover w-full h-full">
                <div class="absolute inset-0 hero-gradient"></div>
            </div>

            <!-- Navigation -->
            <div class="relative">
                @if (Route::has('login'))
                    <nav
                        class="fixed w-full z-50 backdrop-blur-sm bg-white/80 dark:bg-gray-900/80 border-b border-luxury-200/50 dark:border-luxury-800/50 shadow-sm">
                        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                            <div class="flex justify-between h-20">
                                <!-- Logo and Brand -->
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-12 h-12 rounded-full bg-luxury-800 dark:bg-luxury-700 flex items-center justify-center">
                                            <span class="font-serif text-2xl font-bold text-white">
                                                {{ substr(config('app.name'), 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <h1 class="font-serif text-2xl font-bold text-luxury-800 dark:text-luxury-200">
                                            {{ config('app.name') }}
                                        </h1>
                                        <p class="text-sm text-luxury-600 dark:text-luxury-400">Luxury Hotel & Resort
                                        </p>
                                    </div>
                                </div>

                                <!-- Center Navigation -->
                                <div class="hidden md:flex items-center space-x-8">
                                    <a href="#rooms"
                                        class="text-luxury-600 dark:text-luxury-400 hover:text-luxury-800 dark:hover:text-luxury-200 font-medium transition-colors">
                                        Rooms
                                    </a>
                                    <a href="#amenities"
                                        class="text-luxury-600 dark:text-luxury-400 hover:text-luxury-800 dark:hover:text-luxury-200 font-medium transition-colors">
                                        Amenities
                                    </a>
                                    <a href="#contact"
                                        class="text-luxury-600 dark:text-luxury-400 hover:text-luxury-800 dark:hover:text-luxury-200 font-medium transition-colors">
                                        Contact
                                    </a>
                                </div>

                                <!-- Right Navigation -->
                                <div class="flex items-center space-x-6">
                                    <!-- Desktop Navigation -->
                                    <div class="hidden md:flex items-center space-x-6">
                                        @auth
                                            <a href="{{ url('/dashboard') }}"
                                                class="text-luxury-600 dark:text-luxury-400 hover:text-luxury-800 dark:hover:text-luxury-200 font-medium transition-colors">
                                                Dashboard
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="text-luxury-600 dark:text-luxury-400 hover:text-luxury-800 dark:hover:text-luxury-200 font-medium transition-colors">
                                                Sign In
                                            </a>

                                            @if (Route::has('register'))
                                                <a href="{{ route('guest.booking.create') }}"
                                                    class="inline-flex items-center px-4 py-2 bg-luxury-800 dark:bg-luxury-700 text-white font-medium rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                                    <span>Book Now</span>
                                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                    </svg>
                                                </a>
                                            @endif
                                        @endauth

                                        <!-- Dark Mode Toggle -->
                                        <button type="button" data-dark-toggle aria-label="Switch to dark mode"
                                            class="w-10 h-10 rounded-lg bg-luxury-50 dark:bg-gray-800 flex items-center justify-center text-luxury-800 dark:text-luxury-200 hover:bg-luxury-100 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-luxury-500 dark:focus:ring-luxury-400">
                                            <span class="sr-only">Toggle dark mode</span>
                                            <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                            </svg>
                                            <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Mobile Menu Button -->
                                    <button type="button" data-mobile-menu
                                        class="md:hidden w-10 h-10 flex items-center justify-center text-luxury-800 dark:text-luxury-200 hover:bg-luxury-50 dark:hover:bg-gray-800 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-luxury-500 dark:focus:ring-luxury-400"
                                        aria-label="Toggle mobile menu">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path class="mobile-menu-open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6h16M4 12h16M4 18h16" />
                                            <path class="mobile-menu-close hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </nav>
                @endif
            </div>

            <!-- Hero Content -->
            <div class="relative z-10 pt-32 pb-20">
                <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                    <div class="grid lg:grid-cols-2 gap-16 items-center">
                        <div class="space-y-10">
                            <div class="space-y-6">
                                <h2
                                    class="font-serif text-5xl sm:text-6xl lg:text-7xl font-bold text-luxury-800 dark:text-luxury-200 leading-tight">
                                    Experience<br>
                                    Refined Living
                                </h2>
                                <p class="text-xl text-luxury-600 dark:text-luxury-400 max-w-xl leading-relaxed">
                                    Welcome to {{ config('app.name') }}, where exceptional service meets unparalleled
                                    comfort.
                                    @if ($availableRooms ?? 0 > 0)
                                        We currently have {{ $availableRooms }} rooms available for your perfect stay.
                                    @endif
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-6">
                                @auth
                                    {{-- <a href="{{ route('dashboard') }}"
                                        class="inline-flex items-center px-8 py-3 bg-luxury-800 dark:bg-luxury-700 text-white font-semibold rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                        <span>View Dashboard</span>
                                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a> --}}
                                @else
                                    <a href="{{ route('register') }}"
                                        class="inline-flex items-center px-8 py-3 bg-luxury-800 dark:bg-luxury-700 text-white font-semibold rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                        <span>Book Now</span>
                                        <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('login') }}"
                                        class="inline-flex items-center px-8 py-3 bg-white dark:bg-gray-800 text-luxury-800 dark:text-luxury-200 font-semibold rounded-lg hover:bg-luxury-50 dark:hover:bg-gray-700 transition-colors shadow-sm">
                                        Sign In
                                    </a>
                                @endauth
                            </div>
                        </div>

                        <!-- Dynamic Stats -->
                        <div class="grid sm:grid-cols-2 gap-6">
                            @if ($stats ?? null)
                                <div
                                    class="bg-white/90 dark:bg-gray-800/90 p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div class="text-4xl font-bold text-luxury-800 dark:text-luxury-200 mb-2">
                                        {{ $stats['roomCount'] ?? 0 }}+
                                    </div>
                                    <p class="text-luxury-600 dark:text-luxury-400">Luxury Rooms</p>
                                </div>
                                <div
                                    class="bg-white/90 dark:bg-gray-800/90 p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                                    <div class="text-4xl font-bold text-luxury-800 dark:text-luxury-200 mb-2">
                                        {{ $stats['guestCount'] ?? 0 }}+
                                    </div>
                                    <p class="text-luxury-600 dark:text-luxury-400">Happy Guests</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Room Types Section -->
        @if ($roomTypes ?? null)
            <section class="relative py-20 bg-white dark:bg-gray-800">
                <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                    <div class="text-center mb-16">
                        <h2 class="font-serif text-4xl font-bold text-luxury-800 dark:text-luxury-200 mb-4">
                            Our Room Types
                        </h2>
                        <p class="text-luxury-600 dark:text-luxury-400 max-w-2xl mx-auto">
                            Choose from our selection of meticulously designed rooms
                        </p>
                    </div>

                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($roomTypes as $type)
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
                                <div class="aspect-w-16 aspect-h-9">
                                    <img src="{{ $type['image'] ?? 'https://via.placeholder.com/800x600' }}"
                                        alt="{{ $type['name'] }}" class="object-cover w-full h-full">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-luxury-800 dark:text-luxury-200 mb-2">
                                        {{ $type['name'] }}
                                    </h3>
                                    <p class="text-luxury-600 dark:text-luxury-400 mb-4">
                                        {{ $type['description'] }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-2xl font-bold text-luxury-800 dark:text-luxury-200">
                                            ${{ number_format($type['price'], 2) }}
                                        </span>
                                        <span class="text-sm text-luxury-600 dark:text-luxury-400">per night</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- Features Section -->
        <section class="relative py-20 bg-white dark:bg-gray-800 clip-diagonal">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                <div class="text-center mb-16">
                    <h2 class="font-serif text-4xl font-bold text-luxury-800 dark:text-luxury-200 mb-4">
                        Why Choose {{ config('app.name') }}
                    </h2>
                    <p class="text-luxury-600 dark:text-luxury-400 max-w-2xl mx-auto">
                        Immerse yourself in a world of sophistication and comfort, where every detail is crafted to
                        perfection.
                    </p>
                </div>

                <!-- Cards -->
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div
                            class="w-14 h-14 bg-luxury-800 dark:bg-luxury-700 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-luxury-800 dark:text-luxury-200 mb-3">Luxurious Rooms</h3>
                        <p class="text-luxury-600 dark:text-luxury-400 leading-relaxed">Experience comfort in our
                            meticulously designed rooms.</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div
                            class="w-14 h-14 bg-luxury-800 dark:bg-luxury-700 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-luxury-800 dark:text-luxury-200 mb-3">Best Rates</h3>
                        <p class="text-luxury-600 dark:text-luxury-400 leading-relaxed">Competitive prices for an
                            unforgettable
                            stay.</p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div
                            class="w-14 h-14 bg-luxury-800 dark:bg-luxury-700 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-luxury-800 dark:text-luxury-200 mb-3">Premium Service
                        </h3>
                        <p class="text-luxury-600 dark:text-luxury-400 leading-relaxed">Dedicated staff to cater to
                            your every need.
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                        <div
                            class="w-14 h-14 bg-luxury-800 dark:bg-luxury-700 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-luxury-800 dark:text-luxury-200 mb-3">Secure Booking</h3>
                        <p class="text-luxury-600 dark:text-luxury-400 leading-relaxed">Safe and easy reservation
                            process.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Amenities Section -->
        <section class="relative py-20 bg-luxury-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8">
                        <h2 class="font-serif text-4xl font-bold text-luxury-800 dark:text-luxury-200">
                            World-Class Amenities
                        </h2>
                        <div class="grid gap-6">
                            <div class="flex items-start space-x-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-luxury-800 dark:bg-luxury-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-luxury-800 dark:text-luxury-200 mb-2">Spa &
                                        Wellness</h3>
                                    <p class="text-luxury-600 dark:text-luxury-400">Rejuvenate your body and mind in
                                        our state-of-the-art spa facilities.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-luxury-800 dark:bg-luxury-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h.01M12 3h.01M15 3h.01M21 21v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7h18zm-3-9v-2a2 2 0 00-2-2H8a2 2 0 00-2 2v2h12z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-luxury-800 dark:text-luxury-200 mb-2">Fine Dining
                                    </h3>
                                    <p class="text-luxury-600 dark:text-luxury-400">Experience culinary excellence at
                                        our award-winning restaurants.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="aspect-w-16 aspect-h-9 rounded-2xl overflow-hidden shadow-xl">
                            <img src="https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                                alt="Luxury Hotel Amenities" class="object-cover w-full h-full">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-luxury-800 dark:bg-gray-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
                <div class="grid md:grid-cols-3 gap-12">
                    <div>
                        <h3 class="font-serif text-2xl font-bold mb-4">{{ config('app.name') }}</h3>
                        <p class="text-luxury-200 dark:text-luxury-400">
                            Where luxury meets comfort, creating unforgettable experiences.
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-lg mb-4">Quick Links</h4>
                        <ul class="space-y-2">
                            <li><a href="#"
                                    class="text-luxury-200 dark:text-luxury-400 hover:text-white transition-colors">About
                                    Us</a></li>
                            <li><a href="#"
                                    class="text-luxury-200 dark:text-luxury-400 hover:text-white transition-colors">Rooms</a>
                            </li>
                            <li><a href="#"
                                    class="text-luxury-200 dark:text-luxury-400 hover:text-white transition-colors">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold text-lg mb-4">Contact Us</h4>
                        <ul class="space-y-2 text-luxury-200 dark:text-luxury-400">
                            <li>1234 Luxury Avenue</li>
                            <li>New York, NY 10001</li>
                            <li>+1 (555) 123-4567</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-luxury-700 mt-8 pt-8 text-center text-luxury-200 dark:text-luxury-400">
                    <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu hidden fixed inset-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur-sm md:hidden">
        <div class="flex flex-col h-full">
            <!-- Mobile Menu Header -->
            <div class="flex justify-between items-center p-6 border-b border-luxury-200 dark:border-luxury-800">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-full bg-luxury-800 dark:bg-luxury-700 flex items-center justify-center">
                        <span class="font-serif text-lg font-bold text-white">
                            {{ substr(config('app.name'), 0, 1) }}
                        </span>
                    </div>
                    <div>
                        <h2 class="font-serif text-lg font-bold text-luxury-800 dark:text-luxury-200">
                            {{ config('app.name') }}
                        </h2>
                        <p class="text-xs text-luxury-600 dark:text-luxury-400">Luxury Hotel & Resort</p>
                    </div>
                </div>
                
                <!-- Close Button -->
                <button type="button" data-mobile-menu
                    class="w-10 h-10 flex items-center justify-center text-luxury-800 dark:text-luxury-200 hover:bg-luxury-50 dark:hover:bg-gray-800 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-luxury-500 dark:focus:ring-luxury-400"
                    aria-label="Close mobile menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Content -->
            <div class="flex-1 overflow-y-auto p-6">
                <nav class="space-y-1">
                    <!-- Navigation Links -->
                    <a href="#rooms"
                        class="block px-4 py-3 text-lg text-luxury-800 dark:text-luxury-200 hover:bg-luxury-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        Rooms
                    </a>
                    <a href="#amenities"
                        class="block px-4 py-3 text-lg text-luxury-800 dark:text-luxury-200 hover:bg-luxury-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        Amenities
                    </a>
                    <a href="#contact"
                        class="block px-4 py-3 text-lg text-luxury-800 dark:text-luxury-200 hover:bg-luxury-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                        Contact
                    </a>

                    <!-- Divider -->
                    <div class="h-px bg-luxury-200 dark:bg-luxury-800 my-4"></div>

                    <!-- User Actions -->
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="block px-4 py-3 text-lg text-luxury-800 dark:text-luxury-200 hover:bg-luxury-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="block px-4 py-3 text-lg text-luxury-800 dark:text-luxury-200 hover:bg-luxury-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            Sign In
                        </a>

                        @if (Route::has('register'))
                            <a href="{{ route('guest.booking.create') }}"
                                class="block px-4 py-3 mx-4 mt-2 bg-luxury-800 dark:bg-luxury-700 text-white text-center font-semibold rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                Book Now
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>

            <!-- Mobile Menu Footer -->
            <div class="p-6 border-t border-luxury-200 dark:border-luxury-800">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-luxury-600 dark:text-luxury-400">Theme</span>
                    
                    <!-- Dark Mode Toggle -->
                    <button type="button" data-dark-toggle aria-label="Switch to dark mode"
                        class="w-12 h-6 rounded-full bg-luxury-200 dark:bg-luxury-700 relative focus:outline-none focus:ring-2 focus:ring-luxury-500 dark:focus:ring-luxury-400 transition-colors">
                        <div class="w-5 h-5 rounded-full bg-white dark:bg-luxury-200 shadow-sm transform transition-transform translate-x-0.5 dark:translate-x-6 flex items-center justify-center">
                            <svg class="w-3 h-3 text-luxury-800 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                            </svg>
                            <svg class="w-3 h-3 text-luxury-800 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>