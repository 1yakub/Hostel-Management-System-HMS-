@php($room = $room ?? null)
<div class="grid gap-5 md:grid-cols-2">
    <x-field label="Room number" for="room_number" :error="$errors->get('room_number')" help="Dorm beds are rooms too: D1-1, D1-2 and so on.">
        <x-text-input id="room_number" name="room_number" type="text" :value="old('room_number', $room?->room_number)" required maxlength="10" />
    </x-field>
    <x-field label="Room type" for="room_type" :error="$errors->get('room_type')">
        <x-text-input id="room_type" name="room_type" type="text" :value="old('room_type', $room?->room_type)" list="room-types" required maxlength="50" />
        <datalist id="room-types"><option value="Dorm bed"><option value="Private double"><option value="Family room"></datalist>
    </x-field>
    <x-field label="Sleeps" for="capacity" :error="$errors->get('capacity')">
        <x-text-input id="capacity" name="capacity" type="number" min="1" max="12" :value="old('capacity', $room?->capacity)" required />
    </x-field>
    <x-field label="Price per night ({{ config('hms.currency') }})" for="price_per_night" :error="$errors->get('price_per_night')">
        <x-text-input id="price_per_night" name="price_per_night" type="number" step="0.01" min="0" :value="old('price_per_night', $room?->price_per_night)" required />
    </x-field>
    <x-field label="Status" for="status" :error="$errors->get('status')">
        <x-select-input id="status" name="status" required>
            @foreach (['available' => 'Available', 'occupied' => 'Occupied', 'maintenance' => 'Maintenance'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $room?->status ?? 'available') === $value)>{{ $label }}</option>
            @endforeach
        </x-select-input>
    </x-field>
    <x-field label="Photo path" for="featured_image" :error="$errors->get('featured_image')" help="A path under public, for example /images/room-dorm.webp.">
        <x-text-input id="featured_image" name="featured_image" type="text" :value="old('featured_image', $room?->featured_image)" maxlength="255" />
    </x-field>
    <x-field label="Description" for="description" :error="$errors->get('description')" class="md:col-span-2">
        <textarea id="description" name="description" rows="3" maxlength="500" class="w-full rounded-control border-rule bg-white px-3 py-2.5 text-base text-ink focus:border-fern-500 focus:ring-fern-500">{{ old('description', $room?->description) }}</textarea>
    </x-field>
    <x-field label="Amenities" for="amenities" :error="$errors->get('amenities')" help="Comma separated." class="md:col-span-2">
        <x-text-input id="amenities" name="amenities" type="text" :value="old('amenities', is_array($room?->amenities) ? implode(', ', $room->amenities) : '')" maxlength="500" />
    </x-field>
</div>
