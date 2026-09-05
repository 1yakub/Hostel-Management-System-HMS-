<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('guests.index') }}" class="text-sm text-slate hover:text-fern-600">&larr; Guests</a>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">Register a guest</h1>
        </div>
    </x-slot>

    <x-panel class="max-w-xl">
        <form action="{{ route('guests.store') }}" method="POST" class="grid gap-6">
            @csrf
            @include('guests._form')
            <div class="flex justify-end gap-3">
                <a href="{{ route('guests.index') }}" class="rounded-control px-4 py-2.5 text-sm font-medium text-slate hover:text-ink">Cancel</a>
                <x-primary-button>Save guest</x-primary-button>
            </div>
        </form>
    </x-panel>
</x-app-layout>
