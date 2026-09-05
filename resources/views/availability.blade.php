<x-site-layout :title="'Availability, '.config('hms.hostel_name')">
    <section class="mx-auto max-w-6xl px-5 pt-10">
        <a href="{{ url('/#book') }}" class="text-sm text-slate hover:text-fern-600">&larr; Change dates</a>
        <h1 class="title mt-3">
            {{ \Carbon\Carbon::parse($search['check_in'])->format('D j M') }} to {{ \Carbon\Carbon::parse($search['check_out'])->format('D j M') }},
            {{ $nights }} {{ $nights === 1 ? 'night' : 'nights' }}, {{ $search['guests'] }} {{ (int) $search['guests'] === 1 ? 'guest' : 'guests' }}
        </h1>

        @if ($rooms->isEmpty())
            <div class="mt-8 max-w-xl rounded-photo border border-rule bg-chalk-2 p-6">
                <p class="text-lg font-medium">Nothing free for those nights.</p>
                <p class="mt-2 text-slate">Try shifting a day either side, or write to <a href="mailto:{{ config('hms.email') }}" class="underline decoration-rule underline-offset-4 hover:decoration-fern-500">{{ config('hms.email') }}</a> and we will point you to a bed nearby.</p>
            </div>
        @else
            <p class="mt-3 text-slate">{{ $rooms->count() }} {{ $rooms->count() === 1 ? 'option' : 'options' }} free for every night. Prices are for the whole stay.</p>
            <div class="mt-8 grid gap-6">
                @foreach ($rooms->groupBy('room_type') as $type => $group)
                    @php($room = $group->first())
                    <article class="grid gap-5 rounded-photo border border-rule bg-white p-4 md:grid-cols-[280px_1fr_auto] md:items-center md:p-5">
                        <img src="{{ asset(ltrim($room->featured_image, '/')) }}" width="560" height="420" alt="{{ $type }}" class="aspect-[4/3] w-full rounded-control object-cover" loading="lazy">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $type }}</h2>
                            <p class="mt-1 text-slate">{{ $room->description }}</p>
                            <p class="mt-2 text-sm text-slate">Sleeps {{ $room->capacity }} &middot; {{ $group->count() }} free</p>
                        </div>
                        <div class="flex flex-col items-start gap-3 md:items-end">
                            <p class="text-2xl font-semibold">{{ config('hms.currency_symbol') }}{{ number_format($room->price_per_night * $nights, 0) }}<span class="text-base font-normal text-slate"> total</span></p>
                            <p class="text-sm text-slate">{{ config('hms.currency_symbol') }}{{ number_format($room->price_per_night, 0) }} a night</p>
                            <a href="{{ route('guest.booking.create', ['room_id' => $room->id, 'check_in_date' => $search['check_in'], 'check_out_date' => $search['check_out']]) }}" class="rounded-control bg-ink px-5 py-2.5 font-medium text-chalk hover:bg-ink-2">Request this {{ $room->capacity === 1 ? 'bed' : 'room' }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</x-site-layout>
