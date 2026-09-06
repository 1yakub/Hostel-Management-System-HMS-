<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('bookings.index') }}" class="text-sm text-slate hover:text-fern-600">&larr; Bookings</a>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">{{ $booking->guest?->name ?? 'Guest' }} in room {{ $booking->room->room_number }}</h1>
        </div>
        @if ($booking->status === 'active')
            <form action="{{ route('bookings.checkout', $booking) }}" method="POST" x-data @submit.prevent="if (confirm('Check this guest out and free the room?')) $el.submit()">
                @csrf
                @method('PATCH')
                <x-primary-button>Check out</x-primary-button>
            </form>
        @endif
    </x-slot>

    @php($party = $booking->room->bookings()->whereDate('check_in_date', $booking->check_in_date)->whereDate('check_out_date', $booking->check_out_date)->with('guest')->get())

    <div class="grid gap-6 lg:grid-cols-3">
        <x-panel title="Stay" class="lg:col-span-2">
            <dl class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-definition label="Check in">{{ $booking->check_in_date->format('D j M Y') }}</x-definition>
                <x-definition label="Check out">{{ $booking->check_out_date->format('D j M Y') }}</x-definition>
                <x-definition label="Nights">{{ $booking->check_in_date->diffInDays($booking->check_out_date) }}</x-definition>
                <x-definition label="Status"><x-status-badge :status="$booking->status" /></x-definition>
                <x-definition label="Total">{{ config('hms.currency_symbol') }}{{ number_format($booking->total_amount, 2) }}</x-definition>
                <x-definition label="Booked">{{ $booking->created_at->format('j M Y, H:i') }}</x-definition>
            </dl>

            <h3 class="mt-8 text-base font-semibold">Guests on this booking</h3>
            <ul class="mt-3 divide-y divide-rule">
                @foreach ($party as $member)
                    <li class="flex flex-wrap items-center justify-between gap-2 py-3">
                        <div>
                            <p class="font-medium">{{ $member->guest?->name ?? 'Guest' }} @if ($loop->first)<span class="ml-2 rounded-control bg-chalk-2 px-2 py-0.5 text-xs text-slate">Primary</span>@endif</p>
                            <p class="text-sm text-slate">@if ($member->guest?->id_number)ID {{ $member->guest->id_number }}@endif @if ($member->guest?->phone) &middot; {{ $member->guest->phone }}@endif</p>
                        </div>
                        @if ($member->guest)
                            <a href="{{ route('guests.show', $member->guest) }}" class="text-sm text-fern-600 hover:underline">Guest record</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </x-panel>

        <x-panel title="Room">
            <dl class="grid gap-4">
                <x-definition label="Room"><a href="{{ route('rooms.show', $booking->room) }}" class="hover:text-fern-600">{{ $booking->room->room_number }}, {{ $booking->room->room_type }}</a></x-definition>
                <x-definition label="Sleeps">{{ $booking->room->capacity }}</x-definition>
                <x-definition label="Price per night">{{ config('hms.currency_symbol') }}{{ number_format($booking->room->price_per_night, 2) }}</x-definition>
                <x-definition label="Room status"><x-status-badge :status="$booking->room->status" /></x-definition>
            </dl>
        </x-panel>
    </div>
</x-app-layout>
