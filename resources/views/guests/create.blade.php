<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Register New Guest') }}
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
                    <form action="{{ route('guests.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" value="Full Name" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="phone" value="Phone Number" />
                            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full"
                                :value="old('phone')" required placeholder="e.g. +1234567890" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id_number" value="ID Number" />
                            <x-text-input id="id_number" name="id_number" type="text" class="mt-1 block w-full"
                                :value="old('id_number')" required placeholder="e.g. Passport or National ID" />
                            <x-input-error :messages="$errors->get('id_number')" class="mt-2" />
                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>
                                {{ __('Register Guest') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
