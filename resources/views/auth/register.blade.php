<x-guest-layout>
    <h1 class="text-2xl font-semibold tracking-tight">Create an account</h1>
    <p class="mt-1 text-slate">An email and a password is all a booking request needs.</p>

    <form method="POST" action="{{ route('register') }}" class="mt-8 grid gap-5">
        @csrf
        <x-field label="Name" for="name" :error="$errors->get('name')">
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        </x-field>
        <x-field label="Email" for="email" :error="$errors->get('email')">
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
        </x-field>
        <x-field label="Password" for="password" :error="$errors->get('password')" help="At least eight characters.">
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
        </x-field>
        <x-field label="Confirm password" for="password_confirmation" :error="$errors->get('password_confirmation')">
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
        </x-field>
        <x-primary-button class="w-full py-3 text-base">Create account</x-primary-button>
        <p class="text-center text-sm text-slate">Already registered? <a href="{{ route('login') }}" class="text-ink underline decoration-rule underline-offset-4 hover:decoration-fern-500">Sign in</a></p>
    </form>
</x-guest-layout>
