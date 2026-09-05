@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-control border border-fern-100 bg-fern-50 px-4 py-3 text-sm text-fern-700']) }} role="status">
        {{ $status }}
    </div>
@endif
