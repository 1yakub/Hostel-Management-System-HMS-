<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                        <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">
                            {{ __('Rooms') }}
                        </x-nav-link>
                        <x-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')">
                            {{ __('Guests') }}
                        </x-nav-link>
                        <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">
                            {{ __('Bookings') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="flex items-center">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="ml-4">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                            {{ __('Logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                    <a href="{{ route('register') }}" class="ml-4 text-gray-600 hover:text-gray-900">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
