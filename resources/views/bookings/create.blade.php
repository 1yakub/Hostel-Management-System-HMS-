<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('bookings.index') }}" class="text-sm text-slate hover:text-fern-600">&larr; Bookings</a>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">New booking</h1>
        </div>
    </x-slot>

    <x-panel class="max-w-3xl">
        @if ($guests->isEmpty())
            <x-empty-state title="No guests on file" action="Register a guest first" :href="route('guests.create')">A booking needs at least one registered guest.</x-empty-state>
        @else
            <form action="{{ route('bookings.store') }}" method="POST" class="grid gap-6">
                @csrf
                <x-field label="Guests" for="guest_ids" :error="$errors->get('guest_ids') ?: $errors->get('guest_ids.*')" help="Hold Ctrl or Cmd to pick more than one. The first one is the paying guest.">
                    <x-select-input id="guest_ids" name="guest_ids[]" multiple size="6" required>
                        @foreach ($guests as $guest)
                            <option value="{{ $guest->id }}" @selected(in_array($guest->id, old('guest_ids', [])))>{{ $guest->name }} ({{ $guest->id_number }})</option>
                        @endforeach
                    </x-select-input>
                </x-field>
                <p class="-mt-3 text-sm"><a href="{{ route('guests.create') }}" class="text-fern-600 hover:underline">Register a new guest</a></p>

                <x-field label="Room" for="room_id" :error="$errors->get('room_id')">
                    <x-select-input id="room_id" name="room_id" required>
                        <option value="">Choose a room</option>
                        @foreach ($rooms->sortBy('room_number') as $room)
                            <option value="{{ $room->id }}" @selected((int) old('room_id') === $room->id)>{{ $room->room_number }}, {{ $room->room_type }}, sleeps {{ $room->capacity }}, {{ config('hms.currency_symbol') }}{{ number_format($room->price_per_night, 0) }} a night</option>
                        @endforeach
                    </x-select-input>
                </x-field>

                <div class="grid gap-5 sm:grid-cols-2">
                    <x-field label="Check in" for="check_in_date" :error="$errors->get('check_in_date')">
                        <x-text-input id="check_in_date" name="check_in_date" type="date" :value="old('check_in_date', now()->toDateString())" required />
                    </x-field>
                    <x-field label="Check out" for="check_out_date" :error="$errors->get('check_out_date')">
                        <x-text-input id="check_out_date" name="check_out_date" type="date" :value="old('check_out_date', now()->addDay()->toDateString())" required />
                    </x-field>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('bookings.index') }}" class="rounded-control px-4 py-2.5 text-sm font-medium text-slate hover:text-ink">Cancel</a>
                    <x-primary-button>Create booking</x-primary-button>
                </div>
            </form>
        @endif
    </x-panel>
</x-app-layout>
