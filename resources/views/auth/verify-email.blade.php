<x-guest-layout>
    <h1 class="text-2xl font-semibold tracking-tight">Check your email</h1>
    <p class="mt-1 text-slate">We sent a verification link to your address. Click it to finish signing up. Did not get it? We can send another.</p>

    @if (session('status') == 'verification-link-sent')
        <x-auth-session-status class="mt-6" status="A new verification link is on its way." />
    @endif

    <div class="mt-8 flex items-center justify-between gap-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>Resend the email</x-primary-button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-slate underline decoration-rule underline-offset-4 hover:text-ink">Log out</button>
        </form>
    </div>
</x-guest-layout>
