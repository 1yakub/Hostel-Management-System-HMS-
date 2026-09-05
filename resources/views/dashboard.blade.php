<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-semibold tracking-tight">Today, {{ now()->format('l j F') }}</h1>
            <p class="mt-1 text-slate">{{ $stats['checkinsToday'] }} arriving, {{ $stats['checkoutsToday'] }} leaving, {{ $stats['availableRooms'] }} of {{ $stats['totalRooms'] }} beds free.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('bookings.create') }}" class="rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">New booking</a>
            <a href="{{ route('guests.create') }}" class="rounded-control border border-rule bg-white px-4 py-2 text-sm font-medium hover:bg-chalk-2">Register guest</a>
        </div>
    </x-slot>

    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
        <x-stat label="Active bookings" :value="$stats['activeBookings']" :note="$stats['checkoutsToday'].' check out today'" />
        <x-stat label="Free beds and rooms" :value="$stats['availableRooms']" :note="$stats['occupancyRate'].'% occupied'" />
        <x-stat label="Guests on file" :value="$stats['totalGuests']" :note="$stats['newGuestsThisMonth'].' new this month'" />
        <x-stat label="Revenue this month" :value="config('hms.currency_symbol').number_format($stats['monthlyRevenue'], 0)" :note="($stats['revenueGrowth'] >= 0 ? '+' : '').$stats['revenueGrowth'].'% on last month'" />
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <x-panel title="Recent bookings" class="lg:col-span-2">
            @if ($recentBookings->isEmpty())
                <x-empty-state title="No bookings yet" action="Create the first one" :href="route('bookings.create')">Requests from the public site and desk bookings both land here.</x-empty-state>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-slate">
                            <tr class="border-b border-rule">
                                <th class="py-2 pr-4 font-medium">Guest</th>
                                <th class="py-2 pr-4 font-medium">Room</th>
                                <th class="py-2 pr-4 font-medium">Dates</th>
                                <th class="py-2 pr-4 font-medium">Status</th>
                                <th class="py-2 text-right font-medium">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-rule">
                            @foreach ($recentBookings as $booking)
                                <tr>
                                    <td class="py-3 pr-4"><a href="{{ route('bookings.show', $booking) }}" class="font-medium hover:text-fern-600">{{ $booking->guest?->name ?? 'Guest' }}</a></td>
                                    <td class="py-3 pr-4">{{ $booking->room->room_number }} <span class="text-slate">{{ $booking->room->room_type }}</span></td>
                                    <td class="py-3 pr-4 whitespace-nowrap">{{ $booking->check_in_date->format('j M') }} to {{ $booking->check_out_date->format('j M') }}</td>
                                    <td class="py-3 pr-4"><x-status-badge :status="$booking->status" /></td>
                                    <td class="py-3 text-right tabular-nums">{{ config('hms.currency_symbol') }}{{ number_format($booking->total_amount, 0) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-panel>

        <x-panel title="Rooms right now">
            <dl class="grid gap-3">
                <div class="flex items-center justify-between rounded-control bg-fern-50 px-3 py-2"><dt class="text-sm">Available</dt><dd class="font-semibold">{{ $stats['availableRooms'] }}</dd></div>
                <div class="flex items-center justify-between rounded-control bg-chalk-2 px-3 py-2"><dt class="text-sm">Occupied</dt><dd class="font-semibold">{{ $stats['occupiedRooms'] }}</dd></div>
                <div class="flex items-center justify-between rounded-control bg-marigold-100 px-3 py-2"><dt class="text-sm">Maintenance</dt><dd class="font-semibold">{{ $stats['maintenanceRooms'] }}</dd></div>
            </dl>
            <a href="{{ route('rooms.index') }}" class="mt-4 inline-block text-sm text-fern-600 hover:underline">All rooms</a>
        </x-panel>
    </div>
</x-app-layout>
