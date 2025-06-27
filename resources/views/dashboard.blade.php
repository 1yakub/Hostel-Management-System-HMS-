<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif text-2xl font-bold text-luxury-800 dark:text-gold-300">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                <!-- Active Bookings -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Active Bookings</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['activeBookings'] }}</p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['checkoutsToday'] }}
                                checkouts today</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-luxury-700 dark:text-gold-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Available Rooms -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Available Rooms</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                {{ $stats['availableRooms'] }}</p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['occupancyRate'] }}%
                                occupancy rate</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-luxury-700 dark:text-gold-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Guests -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Total Guests</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">{{ $stats['totalGuests'] }}
                            </p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['newGuestsThisMonth'] }}
                                new this month</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-luxury-700 dark:text-gold-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Monthly Revenue -->
                <div
                    class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-luxury-600 dark:text-gold-400">Monthly Revenue</p>
                            <p class="text-2xl font-bold text-luxury-900 dark:text-gold-300">
                                ${{ number_format($stats['monthlyRevenue'], 2) }}</p>
                            <p class="text-sm text-luxury-500 dark:text-gold-500/70">{{ $stats['revenueGrowth'] }}% vs
                                last month</p>
                        </div>
                        <div
                            class="p-3 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full">
                            <svg class="w-6 h-6 text-luxury-700 dark:text-gold-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Status Overview -->
            <div
                class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur">
                <div class="p-6">
                    <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-gold-300 mb-4">Room Status
                        Overview</h3>
                    <div class="grid gap-4 md:grid-cols-3">
                        <!-- Available -->
                        <div
                            class="flex items-center justify-between p-4 bg-gradient-to-br from-green-50/50 to-white/30 dark:from-green-900/20 dark:to-gray-800/30 rounded-lg border border-green-200/20 dark:border-green-500/10">
                            <div>
                                <p class="text-sm font-medium text-green-700 dark:text-green-400">Available</p>
                                <p class="text-2xl font-bold text-green-600 dark:text-green-300">
                                    {{ $stats['availableRooms'] }}</p>
                            </div>
                            <div
                                class="p-2 bg-gradient-to-br from-green-100 to-white dark:from-green-900/30 dark:to-green-900/10 rounded-full">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>

                        <!-- Occupied -->
                        <div
                            class="flex items-center justify-between p-4 bg-gradient-to-br from-blue-50/50 to-white/30 dark:from-blue-900/20 dark:to-gray-800/30 rounded-lg border border-blue-200/20 dark:border-blue-500/10">
                            <div>
                                <p class="text-sm font-medium text-blue-700 dark:text-blue-400">Occupied</p>
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-300">
                                    {{ $stats['occupiedRooms'] }}</p>
                            </div>
                            <div
                                class="p-2 bg-gradient-to-br from-blue-100 to-white dark:from-blue-900/30 dark:to-blue-900/10 rounded-full">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        </div>

                        <!-- Maintenance -->
                        <div
                            class="flex items-center justify-between p-4 bg-gradient-to-br from-amber-50/50 to-white/30 dark:from-amber-900/20 dark:to-gray-800/30 rounded-lg border border-amber-200/20 dark:border-amber-500/10">
                            <div>
                                <p class="text-sm font-medium text-amber-700 dark:text-amber-400">Maintenance</p>
                                <p class="text-2xl font-bold text-amber-600 dark:text-amber-300">
                                    {{ $stats['maintenanceRooms'] }}</p>
                            </div>
                            <div
                                class="p-2 bg-gradient-to-br from-amber-100 to-white dark:from-amber-900/30 dark:to-amber-900/10 rounded-full">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div
                class="bg-gradient-to-br from-white/95 to-white/50 dark:from-gray-800/90 dark:to-gray-900/50 overflow-hidden shadow-luxury gold-border rounded-lg bg-blur">
                <div class="p-6">
                    <h3 class="text-lg font-serif font-semibold text-luxury-800 dark:text-gold-300 mb-4">Quick Actions
                    </h3>
                    <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-4">
                        <a href="{{ route('rooms.create') }}"
                            class="flex items-center p-3 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-colors group">
                            <div
                                class="p-2 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full mr-3 group-hover:from-luxury-200 dark:group-hover:from-gold-800/30">
                                <svg class="w-5 h-5 text-luxury-700 dark:text-gold-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <span
                                class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200">Add
                                New Room</span>
                        </a>

                        <a href="{{ route('bookings.create') }}"
                            class="flex items-center p-3 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-colors group">
                            <div
                                class="p-2 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full mr-3 group-hover:from-luxury-200 dark:group-hover:from-gold-800/30">
                                <svg class="w-5 h-5 text-luxury-700 dark:text-gold-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <span
                                class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200">New
                                Booking</span>
                        </a>

                        <a href="{{ route('guests.create') }}"
                            class="flex items-center p-3 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-colors group">
                            <div
                                class="p-2 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full mr-3 group-hover:from-luxury-200 dark:group-hover:from-gold-800/30">
                                <svg class="w-5 h-5 text-luxury-700 dark:text-gold-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <span
                                class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200">Register
                                Guest</span>
                        </a>

                        <a href="{{ route('rooms.index') }}"
                            class="flex items-center p-3 bg-gradient-to-br from-luxury-50/50 to-white/30 dark:from-gray-800/50 dark:to-gray-900/30 rounded-lg border border-luxury-200/20 dark:border-gold-500/10 hover:bg-luxury-100/50 dark:hover:bg-gold-900/20 transition-colors group">
                            <div
                                class="p-2 bg-gradient-to-br from-luxury-100 to-white dark:from-gold-900/20 dark:to-gray-800/20 rounded-full mr-3 group-hover:from-luxury-200 dark:group-hover:from-gold-800/30">
                                <svg class="w-5 h-5 text-luxury-700 dark:text-gold-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                                </svg>
                            </div>
                            <span
                                class="text-luxury-800 dark:text-gold-300 group-hover:text-luxury-900 dark:group-hover:text-gold-200">View
                                All Rooms</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
