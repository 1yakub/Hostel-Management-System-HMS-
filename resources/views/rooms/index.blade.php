<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Rooms') }}
            </h2>
            <a href="{{ route('rooms.create') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                Add New Room
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Room Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($rooms as $room)
                            <div
                                class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden border border-luxury-200 dark:border-luxury-700">
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-xl font-semibold text-luxury-800 dark:text-luxury-200">
                                                Room {{ $room->room_number }}
                                            </h3>
                                            <p class="text-luxury-600/70 dark:text-luxury-400/70 mt-1">
                                                Capacity: {{ $room->capacity }} persons
                                            </p>
                                        </div>
                                        <span @class([
                                            'px-3 py-1 rounded-full text-sm font-medium',
                                            'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' =>
                                                $room->status === 'available',
                                            'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' =>
                                                $room->status === 'occupied',
                                        ])>
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-2xl font-bold text-luxury-600 dark:text-luxury-400">
                                            ${{ number_format($room->price_per_night, 2) }}
                                            <span
                                                class="text-sm font-normal text-luxury-600/70 dark:text-luxury-400/70">
                                                / night
                                            </span>
                                        </p>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <a href="{{ route('rooms.show', $room) }}"
                                            class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
