@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-medium text-ink']) }}>
    {{ $value ?? $slot }}
</label>
