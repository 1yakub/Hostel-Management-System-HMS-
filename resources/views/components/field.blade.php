@props(['label', 'for', 'error' => null, 'help' => null])

<div class="grid gap-1.5">
    <x-input-label :for="$for" :value="$label" />
    {{ $slot }}
    @if ($help)
        <p class="text-sm text-slate">{{ $help }}</p>
    @endif
    <x-input-error :messages="$error" />
</div>
