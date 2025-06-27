<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Room {{ $room->room_number }} Details
            </h2>
            <div class="space-x-4">
                <a href="{{ route('rooms.edit', $room) }}"
                    class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                    Edit Room
                </a>
                <a href="{{ route('rooms.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                    Back to Rooms
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Room Information -->
                        <div
                            class="bg-luxury-50 dark:bg-luxury-900/50 p-6 rounded-lg border border-luxury-200 dark:border-luxury-800">
                            <h3 class="text-2xl font-semibold text-luxury-800 dark:text-luxury-200 mb-4">
                                Room Information
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Room
                                        Number</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $room->room_number }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Capacity</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $room->capacity }} persons
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Price per
                                        Night</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        ${{ number_format($room->price_per_night, 2) }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Status</label>
                                    <span @class([
                                        'inline-block px-3 py-1 rounded-full text-sm font-medium mt-1',
                                        'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' =>
                                            $room->status === 'available',
                                        'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' =>
                                            $room->status === 'occupied',
                                    ])>
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Current/Last Booking -->
                        <div
                            class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-luxury-200 dark:border-luxury-800">
                            <h3 class="text-2xl font-semibold text-luxury-800 dark:text-luxury-200 mb-4">
                                Current Booking
                            </h3>
                            @if ($room->bookings()->where('status', 'active')->first())
                                @php $booking = $room->bookings()->where('status', 'active')->first() @endphp
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Guest</label>
                                        <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                            {{ $booking?->guest?->name || 'Guest' }}
                                        </p>
                                    </div>
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
                                </div>
                            @else
                                <p class="text-luxury-600/70 dark:text-luxury-400/70">
                                    No active booking for this room.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
