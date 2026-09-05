<x-site-layout>
    {{-- Hero: one photo, one sentence, the booking bar overlapping the bottom edge. --}}
    <section class="relative">
        <div class="mx-auto max-w-6xl px-5 pt-8 md:pt-12">
            <div class="grid items-end gap-8 md:grid-cols-12">
                <div class="md:col-span-7">
                    <h1 class="display">{{ config('hms.tagline') }}</h1>
                </div>
                <p class="measure text-lg text-slate md:col-span-5 md:pb-2">
                    Dorm beds from {{ config('hms.currency_symbol') }}{{ number_format($roomTypes->min('price') ?? 0, 0) }} a night, two private doubles and one family room, in a brick townhouse in {{ config('hms.city') }}. Breakfast in the courtyard is included.
                </p>
            </div>
        </div>
        <div class="mx-auto mt-8 max-w-6xl px-5">
            <figure class="overflow-hidden rounded-photo">
                <img src="{{ asset('images/hero-common-room.webp') }}" width="1600" height="900" alt="The common room: a long shared wooden table by tall windows, travelers reading on a sofa, a wall of shelves holding backpacks" class="aspect-[16/9] w-full object-cover" fetchpriority="high" decoding="async">
            </figure>
        </div>

        {{-- Booking bar --}}
        <div id="book" class="mx-auto -mt-10 max-w-5xl px-5 md:-mt-14">
            <form method="GET" action="{{ route('availability') }}" class="relative grid gap-3 rounded-photo border border-rule bg-chalk p-4 shadow-lift md:grid-cols-[1fr_1fr_0.7fr_auto] md:items-end md:gap-4 md:p-5" x-data="{ tonight: '{{ now()->toDateString() }}' }">
                <label class="grid gap-1 text-sm">
                    <span class="text-slate">Check in</span>
                    <input type="date" name="check_in" required min="{{ now()->toDateString() }}" value="{{ old('check_in', request('check_in', now()->toDateString())) }}" class="rounded-control border-rule bg-white px-3 py-2.5 text-base text-ink focus:border-fern-500 focus:ring-fern-500">
                </label>
                <label class="grid gap-1 text-sm">
                    <span class="text-slate">Check out</span>
                    <input type="date" name="check_out" required min="{{ now()->addDay()->toDateString() }}" value="{{ old('check_out', request('check_out', now()->addDays(2)->toDateString())) }}" class="rounded-control border-rule bg-white px-3 py-2.5 text-base text-ink focus:border-fern-500 focus:ring-fern-500">
                </label>
                <label class="grid gap-1 text-sm">
                    <span class="text-slate">Guests</span>
                    <select name="guests" class="rounded-control border-rule bg-white px-3 py-2.5 text-base text-ink focus:border-fern-500 focus:ring-fern-500">
                        @foreach (range(1, 6) as $n)
                            <option value="{{ $n }}" @selected((int) old('guests', request('guests', 1)) === $n)>{{ $n }} {{ $n === 1 ? 'guest' : 'guests' }}</option>
                        @endforeach
                    </select>
                </label>
                <button type="submit" class="rounded-control bg-marigold-500 px-6 py-3 text-base font-semibold text-ink hover:bg-marigold-600">Check availability</button>
                <p class="text-sm text-slate md:col-span-4">
                    @if ($tonight > 0)
                        {{ $tonight }} {{ $tonight === 1 ? 'bed is' : 'beds and rooms are' }} free tonight. No card needed, you pay at the desk.
                    @else
                        Full tonight. Try another date, or write to us and we will find you a bed nearby.
                    @endif
                </p>
            </form>
        </div>
    </section>

    {{-- Rooms, from the database --}}
    <section id="rooms" class="mx-auto max-w-6xl px-5 pt-24">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 class="title">Three ways to sleep</h2>
            <p class="max-w-md text-slate">Every bed comes with breakfast, Wi-Fi, a locker and clean linen. Prices are per night, per bed for the dorm and per room otherwise.</p>
        </div>
        <div class="mt-10 grid gap-8 md:grid-cols-3">
            @foreach ($roomTypes as $type)
                <article class="grid gap-4">
                    <a href="{{ route('availability', ['check_in' => now()->toDateString(), 'check_out' => now()->addDays(2)->toDateString(), 'guests' => min($type['capacity'], 6)]) }}" class="group block overflow-hidden rounded-photo">
                        <img src="{{ asset(ltrim($type['image'], '/')) }}" width="1024" height="768" alt="{{ $type['name'] }}: {{ $type['description'] }}" class="aspect-[4/3] w-full object-cover transition-transform duration-300 group-hover:scale-[1.02] motion-reduce:transition-none" loading="lazy" decoding="async">
                    </a>
                    <div class="flex items-baseline justify-between gap-3">
                        <h3 class="text-xl font-semibold">{{ $type['name'] }}</h3>
                        <p class="shrink-0 rounded-control bg-marigold-100 px-2.5 py-1 text-sm font-semibold text-ink">{{ config('hms.currency_symbol') }}{{ number_format($type['price'], 0) }} <span class="font-normal text-slate">/ night</span></p>
                    </div>
                    <p class="text-slate">{{ $type['description'] }}</p>
                    <ul class="flex flex-wrap gap-x-3 gap-y-1 text-sm text-slate">
                        <li>Sleeps {{ $type['capacity'] }}</li>
                        @foreach ($type['amenities'] as $a)
                            <li class="before:mr-3 before:text-rule before:content-['|']">{{ $a }}</li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </section>

    {{-- How booking works: the real flow of this system --}}
    <section class="mx-auto max-w-6xl px-5 pt-24">
        <div class="grid gap-10 rounded-photo bg-fern-700 px-6 py-10 text-chalk md:grid-cols-3 md:px-10 md:py-12">
            <div class="md:col-span-3">
                <h2 class="title">How a booking works here</h2>
            </div>
            <div>
                <p class="text-sm text-fern-100">Step one</p>
                <p class="mt-1 text-xl font-semibold">Pick your dates</p>
                <p class="mt-2 text-fern-100">The search only shows beds that are actually free for every night you asked for. No overbooking, no waiting list.</p>
            </div>
            <div>
                <p class="text-sm text-fern-100">Step two</p>
                <p class="mt-1 text-xl font-semibold">Request the bed</p>
                <p class="mt-2 text-fern-100">Sign in with an email and send the request. It holds the bed and lands on the desk screen in the same second.</p>
            </div>
            <div>
                <p class="text-sm text-fern-100">Step three</p>
                <p class="mt-1 text-xl font-semibold">Pay on arrival</p>
                <p class="mt-2 text-fern-100">Card or cash at the desk. Free cancellation until 48 hours before check in.</p>
            </div>
        </div>
    </section>

    {{-- The house --}}
    <section id="stay" class="mx-auto max-w-6xl px-5 pt-24">
        <div class="grid items-center gap-10 md:grid-cols-2">
            <figure class="overflow-hidden rounded-photo">
                <img src="{{ asset('images/courtyard-cafe.webp') }}" width="1024" height="768" alt="The courtyard cafe at breakfast: metal tables, potted lemon trees, a chalkboard, bicycles by the gate" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
            </figure>
            <div>
                <h2 class="title">A house, not a hotel</h2>
                <div class="measure mt-5 grid gap-4 text-slate">
                    <p>Fourteen beds in a converted brick townhouse. One big kitchen table where everyone ends up. A courtyard where breakfast happens and evenings go long.</p>
                    <p>Check in from {{ config('hms.check_in') }}, check out by {{ config('hms.check_out') }}. Bags can wait at the desk before and after. Quiet hours start at 11 PM and are kept.</p>
                    <p>{{ config('hms.address_line') }}, {{ config('hms.city') }}. About 45 minutes from the airport outside rush hour.</p>
                </div>
            </div>
        </div>
        <div class="mt-10 grid items-center gap-10 md:grid-cols-2">
            <div class="md:order-2">
                <figure class="overflow-hidden rounded-photo">
                    <img src="{{ asset('images/reception.webp') }}" width="1024" height="768" alt="The reception desk: reclaimed wood, a brass bell, city maps and numbered wooden key tags" class="aspect-[4/3] w-full object-cover" loading="lazy" decoding="async">
                </figure>
            </div>
            <div>
                <h2 class="title">The desk knows</h2>
                <div class="measure mt-5 grid gap-4 text-slate">
                    <p>Everything you see here runs on the same system the desk uses: rooms, guests, bookings, check in and check out. When you request a bed, the desk sees it at once. When the desk checks someone out, the bed shows as free here.</p>
                    <p>Staff can try the back office with the demo login. Guests can request a stay with any email.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="mx-auto max-w-6xl px-5 pt-24">
        <h2 class="title">Questions people ask</h2>
        <div class="mt-8 grid gap-x-12 md:grid-cols-2">
            @foreach ($faq as $item)
                <details class="group border-t border-rule py-4 last:border-b md:[&:nth-last-child(2)]:border-b">
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 text-lg font-medium marker:content-none">
                        {{ $item['q'] }}
                        <svg class="size-5 shrink-0 text-slate transition-transform group-open:rotate-45 motion-reduce:transition-none" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
                    </summary>
                    <p class="measure mt-3 text-slate">{{ $item['a'] }}</p>
                </details>
            @endforeach
        </div>
    </section>
</x-site-layout>
