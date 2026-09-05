<x-guest-layout>
    <h1 class="text-2xl font-semibold tracking-tight">Reset your password</h1>
    <p class="mt-1 text-slate">Tell us your email and we send a link to choose a new one.</p>

    <x-auth-session-status class="mt-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 grid gap-5">
        @csrf
        <x-field label="Email" for="email" :error="$errors->get('email')">
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
        </x-field>
        <x-primary-button class="w-full py-3 text-base">Email the reset link</x-primary-button>
        <p class="text-center text-sm"><a href="{{ route('login') }}" class="text-slate underline decoration-rule underline-offset-4 hover:text-ink">Back to sign in</a></p>
    </form>
</x-guest-layout>
