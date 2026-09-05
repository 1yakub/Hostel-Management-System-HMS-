<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight">My bookings</h1>
        <a href="{{ route('guest.booking.create') }}" class="rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">Request a stay</a>
    </x-slot>

    <x-panel>
        @include('guest.bookings._list', ['bookings' => $bookings->load('room')])
    </x-panel>
</x-app-layout>
