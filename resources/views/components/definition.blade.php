@props(['label'])

<div>
    <dt class="text-sm text-slate">{{ $label }}</dt>
    <dd class="mt-0.5 font-medium">{{ $slot }}</dd>
</div>
