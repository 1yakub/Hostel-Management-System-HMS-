<x-guest-layout>
    <h1 class="text-2xl font-semibold tracking-tight">Choose a new password</h1>

    <form method="POST" action="{{ route('password.store') }}" class="mt-8 grid gap-5">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <x-field label="Email" for="email" :error="$errors->get('email')">
            <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
        </x-field>
        <x-field label="New password" for="password" :error="$errors->get('password')">
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
        </x-field>
        <x-field label="Confirm new password" for="password_confirmation" :error="$errors->get('password_confirmation')">
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
        </x-field>
        <x-primary-button class="w-full py-3 text-base">Save password</x-primary-button>
    </form>
</x-guest-layout>
