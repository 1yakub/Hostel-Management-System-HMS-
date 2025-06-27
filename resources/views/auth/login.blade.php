<x-guest-layout>
    <div
        class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white/95 dark:bg-gray-800/95 backdrop-blur-2xl shadow-[0_0_40px_rgba(164,126,98,0.12)] dark:shadow-[0_0_40px_rgba(0,0,0,0.25)] rounded-2xl z-10 border border-luxury-200/50 dark:border-luxury-800/50">
        <div class="mb-10 text-center">
            <h2
                class="font-serif text-4xl font-bold bg-gradient-to-r from-luxury-800 to-accent-800 dark:from-luxury-400 dark:to-accent-400 bg-clip-text text-transparent">
                Welcome Back
            </h2>
            <div class="h-1 w-20 bg-gradient-to-r from-luxury-600 to-accent-600 mx-auto mt-4 rounded-full"></div>
            <p class="text-sm text-luxury-600/70 dark:text-luxury-400/70 mt-4">
                Please sign in to your luxury experience
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-7">
            @csrf

            <!-- Email Address -->
            <div class="relative">
                <x-input-label for="email" :value="__('Email')"
                    class="text-luxury-700 dark:text-luxury-300 absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />
                <x-text-input id="email" class="block w-full p-4 border-2" type="email" name="email"
                    :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="relative">
                <x-input-label for="password" :value="__('Password')"
                    class="text-luxury-700 dark:text-luxury-300 absolute -top-2 left-3 bg-white dark:bg-gray-800 px-2 text-sm" />
                <x-text-input id="password" class="block w-full p-4 border-2" type="password" name="password" required
                    autocomplete="current-password" placeholder="Enter your password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded-sm dark:bg-gray-900 border-2 border-luxury-300 dark:border-luxury-700 text-luxury-600 shadow-sm focus:ring-luxury-500 dark:focus:ring-luxury-600 dark:focus:ring-offset-gray-800"
                        name="remember">
                    <span class="ml-2 text-sm text-luxury-600/70 dark:text-luxury-400/70">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-luxury-600 dark:text-luxury-400 hover:text-luxury-700 dark:hover:text-luxury-300 font-medium transition-colors duration-200"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <div>
                <x-primary-button
                    class="w-full justify-center p-4 text-base bg-gradient-to-r from-luxury-600 to-accent-600 hover:from-luxury-700 hover:to-accent-700">
                    {{ __('Sign in') }}
                </x-primary-button>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-luxury-200 dark:border-luxury-700"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white dark:bg-gray-800 text-luxury-600/70 dark:text-luxury-400/70">Don't have
                        an account?</span>
                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('register') }}"
                    class="w-full inline-flex justify-center p-4 text-base font-semibold text-luxury-600 dark:text-luxury-400 border-2 border-luxury-300 dark:border-luxury-600 rounded-lg hover:bg-luxury-50 dark:hover:bg-luxury-900/50 transition-colors duration-200">
                    Register now
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
