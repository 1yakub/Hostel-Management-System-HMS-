<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Guests') }}
            </h2>
            <a href="{{ route('guests.create') }}"
                class="inline-flex items-center px-4 py-2 bg-luxury-600 dark:bg-luxury-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-luxury-700 dark:hover:bg-luxury-600 transition ease-in-out duration-150">
                Register New Guest
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
                                        Name
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Phone
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        ID Number
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-luxury-500 dark:text-luxury-400 uppercase tracking-wider">
                                        Registered
                                    </th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-luxury-200 dark:divide-luxury-700">
                                @foreach ($guests as $guest)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-luxury-900 dark:text-luxury-100">
                                                {{ $guest->name }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-luxury-600 dark:text-luxury-400">
                                                {{ $guest->phone }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-luxury-600 dark:text-luxury-400">
                                                {{ $guest->id_number }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-luxury-600 dark:text-luxury-400">
                                                {{ $guest->created_at->format('M d, Y') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('guests.show', $guest) }}"
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
