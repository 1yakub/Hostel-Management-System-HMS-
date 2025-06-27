<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
                radial-gradient(rgba(183, 147, 111, 0.15) 0.5px, transparent 0.5px),
                radial-gradient(rgba(183, 147, 111, 0.15) 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            background-position: 0 0, 12px 12px;
            opacity: 0.3;
        }

        .dark .pattern-dots {
            background-image:
                radial-gradient(rgba(183, 147, 111, 0.2) 0.5px, transparent 0.5px),
                radial-gradient(rgba(183, 147, 111, 0.2) 0.5px, transparent 0.5px);
        }

        .gradient-overlay {
            background: linear-gradient(135deg,
                    rgba(183, 147, 111, 0.12) 0%,
                    rgba(140, 109, 79, 0.08) 50%,
                    rgba(54, 34, 16, 0.04) 100%);
        }

        .dark .gradient-overlay {
            background: linear-gradient(135deg,
                    rgba(183, 147, 111, 0.18) 0%,
                    rgba(140, 109, 79, 0.12) 50%,
                    rgba(54, 34, 16, 0.08) 100%);
        }

        .bg-blur {
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
        }

        .gold-border {
            border: 1px solid rgba(231, 195, 111, 0.2);
        }

        .dark .gold-border {
            border: 1px solid rgba(231, 195, 111, 0.1);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div
        class="relative min-h-screen bg-gradient-to-br from-luxury-50 via-white to-luxury-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Background Pattern -->
        <div class="fixed inset-0 z-0">
            <div class="absolute inset-0 pattern-dots pointer-events-none"></div>
            <div class="absolute inset-0 gradient-overlay pointer-events-none"></div>

            <!-- Decorative Elements -->
            <div
                class="absolute -left-48 -top-48 w-96 h-96 rounded-full bg-gradient-to-br from-luxury-200/40 via-gold-300/30 to-luxury-300/40 dark:from-luxury-800/20 dark:via-gold-700/15 dark:to-luxury-900/20 blur-3xl">
            </div>
            <div
                class="absolute -right-48 -bottom-48 w-96 h-96 rounded-full bg-gradient-to-br from-gold-200/30 via-luxury-300/25 to-gold-300/30 dark:from-gold-800/20 dark:via-luxury-700/15 dark:to-gold-900/20 blur-3xl">
            </div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] rounded-full bg-gradient-to-br from-white/10 via-gold-100/5 to-luxury-100/10 dark:from-black/10 dark:via-gold-900/5 dark:to-luxury-900/10 backdrop-blur-3xl">
            </div>
        </div>

        <!-- Content -->
        <div class="relative z-10">
            <!-- Navigation -->
            <nav
                class="fixed w-full z-50 bg-white/90 dark:bg-gray-900/90 border-b border-luxury-200/50 dark:border-luxury-800/50 shadow-luxury bg-blur">
                @include('layouts.navigation')
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="pt-20 bg-white/95 dark:bg-gray-800/95 shadow-luxury-lg gold-border bg-blur">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="@if (!isset($header)) pt-20 @endif">
                {{ $slot }}
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
