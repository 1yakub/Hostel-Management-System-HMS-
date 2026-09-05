<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="grid gap-5">
    @csrf
    @method('patch')

    <x-field label="Name" for="name" :error="$errors->get('name')">
        <x-text-input id="name" name="name" type="text" :value="old('name', $user->name)" required autofocus autocomplete="name" />
    </x-field>

    <x-field label="Email" for="email" :error="$errors->get('email')">
        <x-text-input id="email" name="email" type="email" :value="old('email', $user->email)" required autocomplete="username" />
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p class="text-sm text-slate">
                Your email address is unverified.
                <button form="send-verification" class="underline decoration-rule underline-offset-4 hover:text-ink">Send the verification email again.</button>
            </p>
            @if (session('status') === 'verification-link-sent')
                <p class="text-sm text-fern-700">A new verification link has been sent.</p>
            @endif
        @endif
    </x-field>

    <div class="flex items-center gap-4">
        <x-primary-button>Save</x-primary-button>
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-slate">Saved.</p>
        @endif
    </div>
</form>
