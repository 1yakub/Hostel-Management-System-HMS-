<x-guest-layout>
    <h1 class="text-2xl font-semibold tracking-tight">Sign in</h1>
    <p class="mt-1 text-slate">Guests see their booking requests. Staff open the desk.</p>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 grid gap-5">
        @csrf
        <x-field label="Email" for="email" :error="$errors->get('email')">
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
        </x-field>
        <x-field label="Password" for="password" :error="$errors->get('password')">
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
        </x-field>
        <div class="flex items-center justify-between gap-4 text-sm">
            <label for="remember_me" class="inline-flex items-center gap-2">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-rule text-fern-500 focus:ring-fern-500">
                <span class="text-slate">Stay signed in</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-slate underline decoration-rule underline-offset-4 hover:text-ink hover:decoration-fern-500" href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
        </div>
        <x-primary-button class="w-full py-3 text-base">Sign in</x-primary-button>
        <p class="text-center text-sm text-slate">New here? <a href="{{ route('register') }}" class="text-ink underline decoration-rule underline-offset-4 hover:decoration-fern-500">Create an account</a></p>
    </form>
</x-guest-layout>
