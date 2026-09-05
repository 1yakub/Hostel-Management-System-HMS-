@props(['label', 'value', 'note' => null])

<div class="rounded-photo border border-rule bg-white p-5">
    <p class="text-sm text-slate">{{ $label }}</p>
    <p class="mt-1 text-3xl font-semibold tracking-tight">{{ $value }}</p>
    @if ($note)
        <p class="mt-1 text-sm text-slate">{{ $note }}</p>
    @endif
</div>
