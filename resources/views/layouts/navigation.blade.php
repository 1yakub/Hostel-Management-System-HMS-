@php($staff = auth()->user()->is_staff)
<nav x-data="{ open: false }" class="border-b border-rule bg-chalk" aria-label="Back office">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-6 px-5 py-3">
        <div class="flex items-center gap-8">
            <a href="{{ $staff ? route('staff.dashboard') : route('dashboard') }}" class="flex items-center gap-3">
                <span aria-hidden="true" class="grid size-9 place-items-center rounded-control bg-ink text-chalk font-semibold">{{ mb_substr(config('app.name'), 0, 1) }}</span>
                <span class="font-semibold tracking-tight">{{ config('app.name') }} <span class="font-normal text-slate">{{ $staff ? 'desk' : 'guest' }}</span></span>
            </a>
            <div class="hidden items-center gap-1 sm:flex">
                @if ($staff)
                    <x-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">Today</x-nav-link>
                    <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">Bookings</x-nav-link>
                    <x-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">Rooms</x-nav-link>
                    <x-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')">Guests</x-nav-link>
                @else
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Overview</x-nav-link>
                    <x-nav-link :href="route('guest.bookings')" :active="request()->routeIs('guest.bookings')">My bookings</x-nav-link>
                    <x-nav-link :href="route('guest.booking.create')" :active="request()->routeIs('guest.booking.create')">Request a stay</x-nav-link>
                @endif
            </div>
        </div>

        <div class="hidden items-center gap-3 sm:flex">
            <a href="{{ url('/') }}" class="text-sm text-slate hover:text-fern-600">View site</a>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button type="button" class="inline-flex items-center gap-1 rounded-control border border-rule bg-white px-3 py-1.5 text-sm font-medium text-ink hover:bg-chalk-2">
                        {{ Auth::user()->name }}
                        <svg class="size-4 text-slate" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log out</x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <button type="button" class="rounded-control border border-rule p-2 sm:hidden" @click="open = !open" :aria-expanded="open" aria-controls="office-mobile-nav" aria-label="Menu">
            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path x-show="!open" d="M4 7h16M4 12h16M4 17h16" /><path x-show="open" x-cloak d="M6 6l12 12M18 6L6 18" /></svg>
        </button>
    </div>

    <div id="office-mobile-nav" x-show="open" x-cloak class="border-t border-rule px-5 py-3 sm:hidden">
        <div class="grid gap-1">
            @if ($staff)
                <x-responsive-nav-link :href="route('staff.dashboard')" :active="request()->routeIs('staff.dashboard')">Today</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.*')">Bookings</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('rooms.index')" :active="request()->routeIs('rooms.*')">Rooms</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guests.index')" :active="request()->routeIs('guests.*')">Guests</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Overview</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guest.bookings')" :active="request()->routeIs('guest.bookings')">My bookings</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('guest.booking.create')" :active="request()->routeIs('guest.booking.create')">Request a stay</x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="url('/')">View site</x-responsive-nav-link>
        </div>
        <div class="mt-3 border-t border-rule pt-3">
            <p class="px-3 text-sm font-medium">{{ Auth::user()->name }}</p>
            <p class="px-3 text-sm text-slate">{{ Auth::user()->email }}</p>
            <div class="mt-2 grid gap-1">
                <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log out</x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
