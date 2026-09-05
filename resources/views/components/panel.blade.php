@props(['title' => null])

<section {{ $attributes->merge(['class' => 'rounded-photo border border-rule bg-white p-5 md:p-6']) }}>
    @if ($title)
        <h2 class="text-base font-semibold">{{ $title }}</h2>
        <div class="mt-4">{{ $slot }}</div>
    @else
        {{ $slot }}
    @endif
</section>
