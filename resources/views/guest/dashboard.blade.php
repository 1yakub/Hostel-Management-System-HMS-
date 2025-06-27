<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('My Dashboard') }}
            </h2>
            <a href="{{ route('guest.booking.create') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-800 dark:bg-luxury-700 text-white font-medium rounded-lg hover:bg-luxury-900 dark:hover:bg-luxury-600 transition-colors shadow-sm">
                <span>New Booking</span>
                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-gray-800/80 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur">
                <div class="p-6">
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        <!-- Active Bookings -->
                        <div
                            class="bg-gradient-to-br from-luxury-50/90 to-white/90 dark:from-luxury-900/40 dark:to-gray-800/40 p-6 rounded-lg gold-border shadow-luxury">
                            <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-2">
                                Active Bookings</h3>
                            <p class="text-3xl font-bold text-luxury-900 dark:text-luxury-100">
                                {{ auth()->user()->bookings()->where('status', 'active')->count() }}
                            </p>
                        </div>

                        <!-- Upcoming Bookings -->
                        <div
                            class="bg-gradient-to-br from-luxury-50/90 to-white/90 dark:from-luxury-900/40 dark:to-gray-800/40 p-6 rounded-lg gold-border shadow-luxury">
                            <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-2">
                                Upcoming
                                Bookings</h3>
                            <p class="text-3xl font-bold text-luxury-900 dark:text-luxury-100">
                                {{ auth()->user()->bookings()->where('status', 'pending')->count() }}
                            </p>
                        </div>

                        <!-- Total Stays -->
                        <div
                            class="bg-gradient-to-br from-luxury-50/90 to-white/90 dark:from-luxury-900/40 dark:to-gray-800/40 p-6 rounded-lg gold-border shadow-luxury">
                            <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-2">Total
                                Stays</h3>
                            <p class="text-3xl font-bold text-luxury-900 dark:text-luxury-100">
                                {{ auth()->user()->bookings()->where('status', 'completed')->count() }}
                            </p>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="mt-8">
                        <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-luxury-200 mb-4">Recent
                            Bookings</h3>
                        @include('guest.bookings._list', [
                            'bookings' => auth()->user()->bookings()->latest()->take(5)->get(),
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
