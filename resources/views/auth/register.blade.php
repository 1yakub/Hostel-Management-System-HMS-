<x-guest-layout>
    <div
        class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white/95 dark:bg-gray-800/95 backdrop-blur-2xl shadow-[0_0_40px_rgba(164,126,98,0.12)] dark:shadow-[0_0_40px_rgba(0,0,0,0.25)] rounded-2xl z-10 border border-luxury-200/50 dark:border-luxury-800/50">
        <div class="mb-10 text-center">
            <h2
                class="font-serif text-4xl font-bold bg-gradient-to-r from-luxury-800 to-accent-800 dark:from-luxury-400 dark:to-accent-400 bg-clip-text text-transparent">
                Create Account
            </h2>
            <div class="h-1 w-20 bg-gradient-to-r from-luxury-600 to-accent-600 mx-auto mt-4 rounded-full"></div>
            <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70 mt-4">
                Join our exclusive luxury experience
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-7">
            @csrf

            <!-- Name -->
            <div class="relative">
                <x-input-label for="name" :value="__('Name')"
                    class="text-luxury-700 dark:text-luxury-300 absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />
                <x-text-input id="name" class="block w-full p-4 border-2" type="text" name="name"
                    :value="old('name')" required autofocus autocomplete="name" placeholder="Enter your full name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="relative">
                <x-input-label for="email" :value="__('Email')"
                    class="text-luxury-700 dark:text-luxury-300 absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />
                <x-text-input id="email" class="block w-full p-4 border-2" type="email" name="email"
                    :value="old('email')" required autocomplete="username" placeholder="Enter your email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="relative">
                <x-input-label for="password" :value="__('Password')"
                    class="text-luxury-700 dark:text-luxury-300 absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />
                <x-text-input id="password" class="block w-full p-4 border-2" type="password" name="password" required
                    autocomplete="new-password" placeholder="Choose a password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="relative">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')"
                    class="text-luxury-700 dark:text-luxury-300 absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />
                <x-text-input id="password_confirmation" class="block w-full p-4 border-2" type="password"
                    name="password_confirmation" required autocomplete="new-password"
                    placeholder="Confirm your password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div>
                <x-primary-button
                    class="w-full justify-center p-4 text-base bg-gradient-to-r from-luxury-600 to-accent-600 hover:from-luxury-700 hover:to-accent-700">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-luxury-200 dark:border-luxury-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-gray-800 text-luxury-600/70 dark:text-luxury-400/70">Already have
                        an account?</span>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}"
                    class="w-full inline-flex justify-center p-4 text-base font-semibold text-luxury-600 dark:text-luxury-400 border-2 border-luxury-300 dark:border-luxury-600 rounded-lg hover:bg-luxury-50 dark:hover:bg-luxury-900/50 transition-colors duration-200">
                    Sign in
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
