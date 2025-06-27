<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Guest Details
            </h2>
            <a href="{{ route('guests.index') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                Back to Guests
            </a>
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
                                Guest Information
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Name</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $guest->name }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Phone</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $guest->phone }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">ID Number</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $guest->id_number }}
                                    </p>
                                </div>
                                <div>
                                    <label class="text-sm text-luxury-600/70 dark:text-luxury-400/70">Registered
                                        On</label>
                                    <p class="text-lg font-medium text-luxury-800 dark:text-luxury-200">
                                        {{ $guest->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Booking History -->
                        <div
                            class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-luxury-200 dark:border-luxury-800">
                            <h3 class="text-xl font-semibold text-luxury-800 dark:text-luxury-200 mb-4">
                                Booking History
                            </h3>
                            @if ($guest->bookings->count() > 0)
                                <div class="space-y-4">
                                    @foreach ($guest->bookings as $booking)
                                        <div
                                            class="p-4 rounded-lg {{ $booking->status === 'active' ? 'bg-green-50 dark:bg-green-900/10' : 'bg-gray-50 dark:bg-gray-800/50' }}">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium text-luxury-800 dark:text-luxury-200">
                                                        Room {{ $booking->room->room_number }}
                                                    </p>
                                                    <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70">
                                                        {{ $booking->check_in_date->format('M d, Y') }} -
                                                        {{ $booking->check_out_date->format('M d, Y') }}
                                                    </p>
                                                </div>
                                                <span @class([
                                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
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
                                            <div class="mt-2 flex justify-between items-center">
                                                <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70">
                                                    Total: ${{ number_format($booking->total_amount, 2) }}
                                                </p>
                                                <a href="{{ route('bookings.show', $booking) }}"
                                                    class="text-sm text-luxury-600 dark:text-luxury-400 hover:text-luxury-900 dark:hover:text-luxury-300">
                                                    View Details →
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-luxury-600/70 dark:text-luxury-400/70">
                                    No booking history found.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
