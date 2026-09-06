<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('guests.show', $guest) }}" class="text-sm text-slate hover:text-fern-600">&larr; {{ $guest->name }}</a>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">Edit guest</h1>
        </div>
    </x-slot>

    <div class="grid max-w-xl gap-6">
        <x-panel>
            <form action="{{ route('guests.update', $guest) }}" method="POST" class="grid gap-6">
                @csrf
                @method('PUT')
                @include('guests._form')
                <div class="flex justify-end gap-3">
                    <a href="{{ route('guests.show', $guest) }}" class="rounded-control px-4 py-2.5 text-sm font-medium text-slate hover:text-ink">Cancel</a>
                    <x-primary-button>Save changes</x-primary-button>
                </div>
            </form>
        </x-panel>

        <x-panel title="Remove this guest">
            <p class="text-sm text-slate">Only possible when the guest has no active booking.</p>
            <form action="{{ route('guests.destroy', $guest) }}" method="POST" class="mt-4" x-data @submit.prevent="if (confirm('Delete {{ addslashes($guest->name) }}? This cannot be undone.')) $el.submit()">
                @csrf
                @method('DELETE')
                <x-danger-button>Delete guest</x-danger-button>
            </form>
        </x-panel>
    </div>
</x-app-layout>
