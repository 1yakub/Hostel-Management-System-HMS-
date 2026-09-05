@props(['active'])

@php
$classes = ($active ?? false)
    ? 'rounded-control bg-chalk-2 px-3 py-1.5 text-sm font-medium text-ink'
    : 'rounded-control px-3 py-1.5 text-sm font-medium text-slate hover:bg-chalk-2 hover:text-ink';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} @if ($active ?? false) aria-current="page" @endif>
    {{ $slot }}
</a>
