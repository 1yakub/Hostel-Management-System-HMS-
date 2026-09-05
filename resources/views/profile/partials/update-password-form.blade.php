<form method="post" action="{{ route('password.update') }}" class="grid gap-5">
    @csrf
    @method('put')

    <x-field label="Current password" for="update_password_current_password" :error="$errors->updatePassword->get('current_password')">
        <x-text-input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
    </x-field>
    <x-field label="New password" for="update_password_password" :error="$errors->updatePassword->get('password')">
        <x-text-input id="update_password_password" name="password" type="password" autocomplete="new-password" />
    </x-field>
    <x-field label="Confirm new password" for="update_password_password_confirmation" :error="$errors->updatePassword->get('password_confirmation')">
        <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
    </x-field>

    <div class="flex items-center gap-4">
        <x-primary-button>Save</x-primary-button>
        @if (session('status') === 'password-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-slate">Saved.</p>
        @endif
    </div>
</form>
