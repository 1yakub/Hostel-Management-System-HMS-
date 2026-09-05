<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('rooms.index') }}" class="text-sm text-slate hover:text-fern-600">&larr; Rooms</a>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">Room {{ $room->room_number }} <span class="font-normal text-slate">{{ $room->room_type }}</span></h1>
        </div>
        <a href="{{ route('rooms.edit', $room) }}" class="rounded-control border border-rule bg-white px-4 py-2 text-sm font-medium hover:bg-chalk-2">Edit</a>
    </x-slot>

    @php($active = $room->bookings()->whereIn('status', \App\Support\Availability::HOLDING_STATUSES)->orderBy('check_in_date')->with('guest')->get())

    <div class="grid gap-6 lg:grid-cols-3">
        <x-panel title="Details" class="lg:col-span-1">
            @if ($room->featured_image)
                <img src="{{ asset(ltrim($room->featured_image, '/')) }}" width="600" height="450" alt="" class="mb-4 aspect-[4/3] w-full rounded-control object-cover">
            @endif
            <dl class="grid gap-4">
                <x-definition label="Status"><x-status-badge :status="$room->status" /></x-definition>
                <x-definition label="Sleeps">{{ $room->capacity }}</x-definition>
                <x-definition label="Price per night">{{ config('hms.currency_symbol') }}{{ number_format($room->price_per_night, 2) }}</x-definition>
                @if ($room->description)
                    <x-definition label="Description">{{ $room->description }}</x-definition>
                @endif
                @if ($room->amenities)
                    <x-definition label="Amenities">{{ implode(', ', $room->amenities) }}</x-definition>
                @endif
            </dl>
        </x-panel>

        <x-panel title="Upcoming and current bookings" class="lg:col-span-2">
            @if ($active->isEmpty())
                <p class="text-slate">No active booking. The room shows as free on the public site.</p>
            @else
                <table class="w-full text-sm">
                    <thead class="text-left text-slate">
                        <tr class="border-b border-rule">
                            <th class="py-2 pr-4 font-medium">Guest</th>
                            <th class="py-2 pr-4 font-medium">Check in</th>
                            <th class="py-2 pr-4 font-medium">Check out</th>
                            <th class="py-2 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rule">
                        @foreach ($active as $booking)
                            <tr>
                                <td class="py-3 pr-4"><a href="{{ route('bookings.show', $booking) }}" class="font-medium hover:text-fern-600">{{ $booking->guest?->name ?? 'Guest' }}</a></td>
                                <td class="py-3 pr-4">{{ $booking->check_in_date->format('D j M Y') }}</td>
                                <td class="py-3 pr-4">{{ $booking->check_out_date->format('D j M Y') }}</td>
                                <td class="py-3"><x-status-badge :status="$booking->status" /></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </x-panel>
    </div>
</x-app-layout>
