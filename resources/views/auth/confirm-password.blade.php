<x-guest-layout>
    <h1 class="text-2xl font-semibold tracking-tight">Confirm your password</h1>
    <p class="mt-1 text-slate">This is a secure area. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 grid gap-5">
        @csrf
        <x-field label="Password" for="password" :error="$errors->get('password')">
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
        </x-field>
        <x-primary-button class="w-full py-3 text-base">Confirm</x-primary-button>
    </form>
</x-guest-layout>
