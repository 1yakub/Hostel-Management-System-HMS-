<x-app-layout>
    <div class="relative bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                    <span class="block">Welcome to</span>
                    <span class="block text-blue-600">Hostel Management System</span>
                </h1>
                <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                    Efficiently manage your hostel bookings, rooms, and guests with our comprehensive management system.
                </p>
                <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                    @auth
                        <div class="rounded-md shadow">
                            <a href="{{ route('dashboard') }}"
                                class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                Go to Dashboard
                            </a>
                        </div>
                    @else
                        <div class="rounded-md shadow">
                            <a href="{{ route('login') }}"
                                class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                Login
                            </a>
                        </div>
                        <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                            <a href="{{ route('register') }}"
                                class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                Register
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="text-center">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Room Management</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Efficiently manage all your rooms, their availability, and pricing.
                        </p>
                    </div>

                    <div class="text-center">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Guest Management</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Keep track of all your guests and their booking history.
                        </p>
                    </div>

                    <div class="text-center">
                        <div
                            class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Booking System</h3>
                        <p class="mt-2 text-base text-gray-500">
                            Simple and efficient booking management with automated calculations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
