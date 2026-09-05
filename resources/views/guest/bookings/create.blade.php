<x-guest-booking-layout>
    <section class="mx-auto max-w-6xl px-5 pt-10">
        <a href="{{ url('/#book') }}" class="text-sm text-slate hover:text-fern-600">&larr; Back to availability</a>
        <h1 class="title mt-3">Request your stay</h1>
        <p class="mt-2 max-w-xl text-slate">This holds the bed for you. Nothing is charged now, you pay at the desk when you arrive. Free cancellation until 48 hours before check in.</p>

        <form method="POST" action="{{ route('guest.booking.store') }}" class="mt-8 grid max-w-2xl gap-6 rounded-photo border border-rule bg-white p-5 md:p-6">
            @csrf
            <x-field label="Bed or room" for="room_id" :error="$errors->get('room_id')">
                <x-select-input id="room_id" name="room_id" required>
                    @foreach ($availableRooms as $type => $rooms)
                        <optgroup label="{{ $type }}">
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected((int) old('room_id', request('room_id')) === $room->id)>{{ $type }} {{ $room->room_number }}, sleeps {{ $room->capacity }}, {{ config('hms.currency_symbol') }}{{ number_format($room->price_per_night, 0) }} a night</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </x-select-input>
            </x-field>
            <div class="grid gap-5 sm:grid-cols-2">
                <x-field label="Check in" for="check_in_date" :error="$errors->get('check_in_date')">
                    <x-text-input id="check_in_date" name="check_in_date" type="date" :value="old('check_in_date', request('check_in_date'))" min="{{ now()->addDay()->toDateString() }}" required />
                </x-field>
                <x-field label="Check out" for="check_out_date" :error="$errors->get('check_out_date')">
                    <x-text-input id="check_out_date" name="check_out_date" type="date" :value="old('check_out_date', request('check_out_date'))" min="{{ now()->addDays(2)->toDateString() }}" required />
                </x-field>
            </div>
            <div class="flex items-center justify-between gap-4">
                <p class="text-sm text-slate">Booked as {{ auth()->user()->name }}, {{ auth()->user()->email }}.</p>
                <button type="submit" class="rounded-control bg-marigold-500 px-6 py-3 font-semibold text-ink hover:bg-marigold-600">Send request</button>
            </div>
        </form>
    </section>
</x-guest-booking-layout>
