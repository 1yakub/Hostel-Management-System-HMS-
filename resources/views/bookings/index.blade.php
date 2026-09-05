<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight">Bookings</h1>
        <a href="{{ route('bookings.create') }}" class="rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">New booking</a>
    </x-slot>

    @if ($bookings->isEmpty())
        <x-empty-state title="No bookings yet" action="Create a booking" :href="route('bookings.create')">Requests from the public site and desk bookings both land here.</x-empty-state>
    @else
        <x-panel class="p-0 md:p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate">
                        <tr class="border-b border-rule">
                            <th class="px-5 py-3 font-medium">Guest</th>
                            <th class="px-5 py-3 font-medium">Room</th>
                            <th class="px-5 py-3 font-medium">Check in</th>
                            <th class="px-5 py-3 font-medium">Check out</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                            <th class="px-5 py-3 text-right font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rule">
                        @foreach ($bookings->sortByDesc('check_in_date') as $booking)
                            <tr class="hover:bg-chalk">
                                <td class="px-5 py-3">
                                    <a href="{{ route('bookings.show', $booking) }}" class="font-medium hover:text-fern-600">{{ $booking->guest?->name ?? 'Guest' }}</a>
                                    @if ($booking->guest?->id_number)<div class="text-slate">{{ $booking->guest->id_number }}</div>@endif
                                </td>
                                <td class="px-5 py-3">{{ $booking->room->room_number }} <span class="text-slate">{{ $booking->room->room_type }}</span></td>
                                <td class="px-5 py-3 whitespace-nowrap">{{ $booking->check_in_date->format('D j M Y') }}</td>
                                <td class="px-5 py-3 whitespace-nowrap">{{ $booking->check_out_date->format('D j M Y') }}</td>
                                <td class="px-5 py-3"><x-status-badge :status="$booking->status" /></td>
                                <td class="px-5 py-3 text-right tabular-nums">{{ config('hms.currency_symbol') }}{{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    @endif
</x-app-layout>
