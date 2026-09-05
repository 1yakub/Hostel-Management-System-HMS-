<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Hello, {{ auth()->user()->name }}</h1>
            <p class="mt-1 text-slate">Your stays at {{ config('hms.hostel_name') }}.</p>
        </div>
        <a href="{{ route('guest.booking.create') }}" class="rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">Request a stay</a>
    </x-slot>

    @php($bookings = auth()->user()->bookings()->with('room')->latest()->get())

    <div class="grid gap-4 sm:grid-cols-3">
        <x-stat label="Upcoming" :value="$bookings->where('status', 'active')->where('check_in_date', '>=', today())->count()" />
        <x-stat label="Staying now" :value="$bookings->where('status', 'active')->where('check_in_date', '<', today())->count()" />
        <x-stat label="Past stays" :value="$bookings->where('status', 'completed')->count()" />
    </div>

    <x-panel title="Your bookings" class="mt-6">
        @include('guest.bookings._list', ['bookings' => $bookings])
    </x-panel>
</x-app-layout>
