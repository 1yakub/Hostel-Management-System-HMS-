@props(['disabled' => false])

<select @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-control border-rule bg-white px-3 py-2.5 text-base text-ink focus:border-fern-500 focus:ring-fern-500 disabled:bg-chalk-2']) }}>
    {{ $slot }}
</select>
