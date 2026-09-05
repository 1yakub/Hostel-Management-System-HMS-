@if ($bookings->isEmpty())
    <x-empty-state title="No bookings yet" action="Check availability" :href="url('/#book')">Pick your dates on the site, choose a bed, and the request shows up here.</x-empty-state>
@else
    <ul class="divide-y divide-rule">
        @foreach ($bookings as $booking)
            <li class="flex flex-wrap items-center justify-between gap-3 py-4">
                <div class="flex items-center gap-4">
                    @if ($booking->room->featured_image)
                        <img src="{{ asset(ltrim($booking->room->featured_image, '/')) }}" width="96" height="72" alt="" class="hidden aspect-[4/3] w-24 rounded-control object-cover sm:block">
                    @endif
                    <div>
                        <p class="font-medium">{{ $booking->room->room_type }} <span class="text-slate">room {{ $booking->room->room_number }}</span></p>
                        <p class="text-sm text-slate">{{ $booking->check_in_date->format('D j M Y') }} to {{ $booking->check_out_date->format('D j M Y') }}, {{ $booking->check_in_date->diffInDays($booking->check_out_date) }} {{ $booking->check_in_date->diffInDays($booking->check_out_date) === 1 ? 'night' : 'nights' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <x-status-badge :status="$booking->status" />
                    <p class="font-medium tabular-nums">{{ config('hms.currency_symbol') }}{{ number_format($booking->total_amount, 0) }} <span class="text-sm font-normal text-slate">at the desk</span></p>
                </div>
            </li>
        @endforeach
    </ul>
@endif
