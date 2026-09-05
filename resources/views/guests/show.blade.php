<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('guests.index') }}" class="text-sm text-slate hover:text-fern-600">&larr; Guests</a>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">{{ $guest->name }}</h1>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('bookings.create') }}" class="rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">New booking</a>
            <a href="{{ route('guests.edit', $guest) }}" class="rounded-control border border-rule bg-white px-4 py-2 text-sm font-medium hover:bg-chalk-2">Edit</a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <x-panel title="Contact">
            <dl class="grid gap-4">
                <x-definition label="Phone"><a href="tel:{{ preg_replace('/\s+/', '', $guest->phone) }}" class="hover:text-fern-600">{{ $guest->phone }}</a></x-definition>
                <x-definition label="ID number"><span class="font-mono text-sm">{{ $guest->id_number }}</span></x-definition>
                <x-definition label="Registered">{{ $guest->created_at->format('j M Y') }}</x-definition>
            </dl>
        </x-panel>

        <x-panel title="Stays" class="lg:col-span-2">
            @if ($guest->bookings->isEmpty())
                <p class="text-slate">No bookings yet.</p>
            @else
                <table class="w-full text-sm">
                    <thead class="text-left text-slate">
                        <tr class="border-b border-rule">
                            <th class="py-2 pr-4 font-medium">Room</th>
                            <th class="py-2 pr-4 font-medium">Dates</th>
                            <th class="py-2 pr-4 font-medium">Status</th>
                            <th class="py-2 text-right font-medium">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rule">
                        @foreach ($guest->bookings->sortByDesc('check_in_date') as $booking)
                            <tr>
                                <td class="py-3 pr-4"><a href="{{ route('bookings.show', $booking) }}" class="font-medium hover:text-fern-600">{{ $booking->room->room_number }}</a> <span class="text-slate">{{ $booking->room->room_type }}</span></td>
                                <td class="py-3 pr-4 whitespace-nowrap">{{ $booking->check_in_date->format('j M Y') }} to {{ $booking->check_out_date->format('j M Y') }}</td>
                                <td class="py-3 pr-4"><x-status-badge :status="$booking->status" /></td>
                                <td class="py-3 text-right tabular-nums">{{ config('hms.currency_symbol') }}{{ number_format($booking->total_amount, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-panel>
    </div>
</x-app-layout>
