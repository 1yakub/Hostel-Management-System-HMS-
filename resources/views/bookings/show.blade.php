<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Booking Details
            </h2>
            <div class="space-x-4">
                @if ($booking->status === 'active')
                    <form action="{{ route('bookings.checkout', $booking) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150"
                            onclick="return confirm('Are you sure you want to check out this guest?')">
                            Check Out
                        </button>
                    </form>
                @endif
                <a href="{{ route('bookings.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                    Back to Bookings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Guest Information -->
                        <div
                            class="bg-luxury-50 dark:bg-luxury-900/50 p-6 rounded-lg border border-luxury-200 dark:border-luxury-800">
                            <h3 class="text-xl font-semibold text-luxury-800 dark:text-luxury-200 mb-4">
                                Guests Information
                            </h3>
                            <div class="space-y-4">
                                @foreach ($booking->room->bookings()->where('check_in_date', $booking->check_in_date)->get() as $guestBooking)
                                    <div
                                        class="p-4 {{ $loop->first ? 'bg-white/50' : 'bg-white/30' }} dark:bg-gray-800/50 rounded-lg">
                                        <div class="flex justify-between items-start mb-2">
                                            <h4 class="font-medium text-luxury-800 dark:text-luxury-200">
                                                {{ $guestBooking?->guest?->name || 'Guest' }}
                                                @if ($loop->first)
                                                    <span
                                                        class="text-xs text-luxury-600 dark:text-luxury-400 ml-2">Primary
                                                        Guest</span>
                                                @endif
                                            </h4>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70">
                                                ID: {{ $guestBooking?->guest?->id_number }}
                                            </p>
                                            <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70">
                                                Phone: {{ $guestBooking?->guest?->phone }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Room Information -->
                        <div
                            class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-luxury-200 dark:border-luxury-800">
                            <h3 class="text-xl font-semibold text-luxury-800 dark:text-luxury-200 mb-4">
                                Room Information
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Room
                                        Number</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $booking->room->room_number }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Capacity</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $booking->room->capacity }} persons
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Price per
                                        Night</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        ${{ number_format($booking->room->price_per_night, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Booking Details -->
                        <div
                            class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-luxury-200 dark:border-luxury-800 md:col-span-2">
                            <h3 class="text-xl font-semibold text-luxury-800 dark:text-luxury-200 mb-4">
                                Booking Details
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Check-in
                                        Date</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $booking->check_in_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Check-out
                                        Date</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $booking->check_out_date->format('M d, Y') }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Status</label>
                                    <span @class([
                                        'inline-block px-3 py-1 rounded-full text-sm font-medium mt-1',
                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' =>
                                            $booking->status === 'active',
                                        'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' =>
                                            $booking->status === 'completed',
                                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' =>
                                            $booking->status === 'cancelled',
                                    ])>
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Total
                                        Amount</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        ${{ number_format($booking->total_amount, 2) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
