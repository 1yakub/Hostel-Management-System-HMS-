<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight">Profile</h1>
    </x-slot>

    <div class="grid max-w-2xl gap-6">
        <x-panel title="Your details">
            @include('profile.partials.update-profile-information-form')
        </x-panel>
        <x-panel title="Password">
            @include('profile.partials.update-password-form')
        </x-panel>
        <x-panel title="Delete account">
            @include('profile.partials.delete-user-form')
        </x-panel>
    </div>
</x-app-layout>
