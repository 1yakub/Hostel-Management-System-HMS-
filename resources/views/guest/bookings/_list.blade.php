@if ($bookings->isEmpty())
    <p class="text-luxury-600 dark:text-luxury-400">No bookings found.</p>
@else
    <div class="space-y-4">
        @foreach ($bookings as $booking)
            <div
                class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 bg-luxury-50 dark:bg-luxury-900/50 rounded-lg">
                <div class="flex items-center space-x-4">
                    <div
                        class="p-2 bg-{{ $booking->status_color }}-100 dark:bg-{{ $booking->status_color }}-900/30 rounded-full">
                        <svg class="w-5 h-5 text-{{ $booking->status_color }}-600 dark:text-{{ $booking->status_color }}-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-medium text-luxury-900 dark:text-luxury-100">
                            Room {{ $booking->room->room_number }} - {{ $booking->room->room_type }}
                        </h4>
                        <p class="text-sm text-luxury-600 dark:text-luxury-400">
                            {{ $booking->check_in_date->format('M d, Y') }} -
                            {{ $booking->check_out_date->format('M d, Y') }}
                        </p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex items-center space-x-4">
                    <span
                        class="px-3 py-1 text-sm font-medium rounded-full
                        {{ $booking->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : '' }}
                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}
                        {{ $booking->status === 'completed' ? 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400' : '' }}
                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400' : '' }}
                    ">
                        {{ ucfirst($booking->status) }}
                    </span>
                    <span class="text-luxury-800 dark:text-luxury-200 font-medium">
                        ${{ number_format($booking->total_amount, 2) }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
@endif
