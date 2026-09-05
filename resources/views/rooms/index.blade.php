<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight">Rooms</h1>
        <a href="{{ route('rooms.create') }}" class="rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">Add room</a>
    </x-slot>

    @if ($rooms->isEmpty())
        <x-empty-state title="No rooms yet" action="Add the first room" :href="route('rooms.create')">Rooms and dorm beds appear on the public site as soon as they are added.</x-empty-state>
    @else
        <x-panel class="p-0 md:p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate">
                        <tr class="border-b border-rule">
                            <th class="px-5 py-3 font-medium">Room</th>
                            <th class="px-5 py-3 font-medium">Type</th>
                            <th class="px-5 py-3 font-medium">Sleeps</th>
                            <th class="px-5 py-3 font-medium">Status</th>
                            <th class="px-5 py-3 text-right font-medium">Per night</th>
                            <th class="px-5 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rule">
                        @foreach ($rooms->sortBy('room_number') as $room)
                            <tr class="hover:bg-chalk">
                                <td class="px-5 py-3 font-medium"><a href="{{ route('rooms.show', $room) }}" class="hover:text-fern-600">{{ $room->room_number }}</a></td>
                                <td class="px-5 py-3">{{ $room->room_type }}</td>
                                <td class="px-5 py-3">{{ $room->capacity }}</td>
                                <td class="px-5 py-3"><x-status-badge :status="$room->status" /></td>
                                <td class="px-5 py-3 text-right tabular-nums">{{ config('hms.currency_symbol') }}{{ number_format($room->price_per_night, 0) }}</td>
                                <td class="px-5 py-3 text-right"><a href="{{ route('rooms.edit', $room) }}" class="text-slate hover:text-fern-600">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    @endif
</x-app-layout>
