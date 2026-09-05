<p class="text-sm text-slate">Deleting your account removes your booking requests too. Enter your password to confirm.</p>

<x-danger-button class="mt-4" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">Delete account</x-danger-button>

<x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
    <form method="post" action="{{ route('profile.destroy') }}" class="grid gap-5 p-6">
        @csrf
        @method('delete')
        <h2 class="text-lg font-semibold">Delete your account?</h2>
        <p class="text-sm text-slate">This cannot be undone. Enter your password to confirm.</p>
        <x-field label="Password" for="password" :error="$errors->userDeletion->get('password')">
            <x-text-input id="password" name="password" type="password" placeholder="Password" />
        </x-field>
        <div class="flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">Cancel</x-secondary-button>
            <x-danger-button>Delete account</x-danger-button>
        </div>
    </form>
</x-modal>
