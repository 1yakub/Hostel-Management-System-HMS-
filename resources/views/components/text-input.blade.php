@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-control border-rule bg-white px-3 py-2.5 text-base text-ink placeholder:text-slate-2 focus:border-fern-500 focus:ring-fern-500 disabled:bg-chalk-2']) }}>
