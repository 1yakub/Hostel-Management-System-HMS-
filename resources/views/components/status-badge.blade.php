@props(['status'])

@php
$tone = match ($status) {
    'available', 'active', 'confirmed', 'checked_in' => 'bg-fern-50 text-fern-700 border-fern-100',
    'occupied', 'completed', 'checked_out' => 'bg-chalk-2 text-slate border-rule',
    'maintenance', 'pending' => 'bg-marigold-100 text-ink border-marigold-500/30',
    'cancelled' => 'bg-red-50 text-danger border-danger/20',
    default => 'bg-chalk-2 text-slate border-rule',
};
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-control border px-2 py-0.5 text-xs font-medium $tone"]) }}>
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
