<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Bookings') }}
            </h2>
            <a href="{{ route('bookings.create') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                New Booking
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-luxury-200 dark:border-luxury-700">
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Guest
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Room
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Check-in
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Check-out
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Amount
                                    </th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-luxury-200 dark:divide-luxury-700">
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-luxury-900 dark:text-luxury-100">
                                                {{ $booking?->guest?->name || 'Guest' }}
                                            </div>
                                            <div class="text-sm text-luxury-500 dark:text-luxury-400">
                                                {{ $booking?->guest?->id_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-luxury-900 dark:text-luxury-100">
                                                Room {{ $booking->room->room_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-luxury-900 dark:text-luxury-100">
                                                {{ $booking->check_in_date->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-luxury-900 dark:text-luxury-100">
                                                {{ $booking->check_out_date->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
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
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-luxury-900 dark:text-luxury-100">
                                            ${{ number_format($booking->total_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('bookings.show', $booking) }}"
                                                class="text-luxury-600 dark:text-luxury-400 hover:text-luxury-900 dark:hover:text-luxury-300">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
