<nav x-data="{ open: false }"
    class="bg-white dark:bg-gray-800 border-b border-luxury-200 dark:border-luxury-800 shadow-luxury">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->is_staff ? route('staff.dashboard') : route('guest.dashboard') }}"
                        class="flex items-center space-x-2">
                        <div
                            class="w-10 h-10 rounded-full bg-luxury-800 dark:bg-luxury-700 flex items-center justify-center">
                            <span class="font-serif text-xl font-bold text-white">
                                {{ substr(config('app.name'), 0, 1) }}
                            </span>
                        </div>
                        <span class="font-serif text-xl font-bold text-luxury-800 dark:text-luxury-200">
                            {{ config('app.name') }}
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if (auth()->user()->is_staff)
                        <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">
                            {{ __('Rooms') }}
                        </x-nav-link>
                        <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                            {{ __('Bookings') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')">
                            {{ __('Guests') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('guest.dashboard')" :active="request()->routeIs('guest.dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guest.bookings')" :active="request()->routeIs('guest.bookings')">
                            {{ __('My Bookings') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                <!-- Dark mode toggle -->
                <button type="button" data-dark-toggle
                    class="p-2 text-luxury-800 dark:text-luxury-200 hover:bg-luxury-100 dark:hover:bg-luxury-800 rounded-lg focus:outline-none focus:ring-2 focus:ring-luxury-500 dark:focus:ring-luxury-400">
                    <span class="sr-only">Toggle dark mode</span>
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707" />
                    </svg>
                </button>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-luxury-600 dark:text-luxury-400 bg-white dark:bg-gray-800 hover:text-luxury-800 dark:hover:text-luxury-200 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="font-medium">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="font-medium text-red-600 dark:text-red-400">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-luxury-500 dark:text-luxury-400 hover:text-luxury-800 dark:hover:text-luxury-200 hover:bg-luxury-100 dark:hover:bg-luxury-900 focus:outline-none focus:bg-luxury-100 dark:focus:bg-luxury-900 focus:text-luxury-800 dark:focus:text-luxury-200 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if (auth()->user()->is_staff)
                <x-responsive-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">
                    {{ __('Rooms') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                    {{ __('Bookings') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')">
                    {{ __('Guests') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('guest.dashboard')" :active="request()->routeIs('guest.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guest.bookings')" :active="request()->routeIs('guest.bookings')">
                    {{ __('My Bookings') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
