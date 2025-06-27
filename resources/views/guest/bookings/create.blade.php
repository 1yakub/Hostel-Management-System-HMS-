<x-guest-booking-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-2xl font-serif font-bold text-luxury-800 dark:text-luxury-200">Book Your Stay
                        </h2>
                        <p class="mt-1 text-sm text-luxury-600 dark:text-luxury-400">Select your room and dates for a
                            luxurious experience.</p>
                    </div>

                    <form method="POST" action="{{ route('guest.booking.store') }}" class="space-y-6">
                        @csrf

                        <!-- Room Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Select Room Type
                            </label>
                            <select name="room_id"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                @foreach ($availableRooms as $type => $rooms)
                                    <optgroup label="{{ $type }}">
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->id }}">
                                                Room {{ $room->room_number }} - ${{ $room->price_per_night }}/night
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('room_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Check-in Date
                                </label>
                                <input type="date" name="check_in_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                @error('check_in_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Check-out Date
                                </label>
                                <input type="date" name="check_out_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300">
                                @error('check_out_date')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-luxury-800 dark:bg-luxury-700 text-white font-medium rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                                Proceed to Book
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-booking-layout>
