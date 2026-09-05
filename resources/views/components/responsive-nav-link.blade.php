@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block rounded-control bg-chalk-2 px-3 py-2 text-base font-medium text-ink'
    : 'block rounded-control px-3 py-2 text-base font-medium text-slate hover:bg-chalk-2 hover:text-ink';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} @if ($active ?? false) aria-current="page" @endif>
    {{ $slot }}
</a>
