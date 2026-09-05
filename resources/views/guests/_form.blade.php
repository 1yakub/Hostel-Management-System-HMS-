@php($guest = $guest ?? null)
<div class="grid gap-5">
    <x-field label="Full name" for="name" :error="$errors->get('name')">
        <x-text-input id="name" name="name" type="text" :value="old('name', $guest?->name)" required maxlength="100" autocomplete="off" />
    </x-field>
    <x-field label="Phone" for="phone" :error="$errors->get('phone')">
        <x-text-input id="phone" name="phone" type="tel" :value="old('phone', $guest?->phone)" required maxlength="20" autocomplete="off" />
    </x-field>
    <x-field label="ID number" for="id_number" :error="$errors->get('id_number')" help="Passport or national ID, as shown at the desk.">
        <x-text-input id="id_number" name="id_number" type="text" :value="old('id_number', $guest?->id_number)" required maxlength="50" autocomplete="off" />
    </x-field>
</div>
