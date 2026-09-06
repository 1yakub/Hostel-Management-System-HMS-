<x-app-layout>
    <x-slot name="header">
        <div>
            <a href="{{ route('rooms.show', $room) }}" class="text-sm text-slate hover:text-fern-600">&larr; Room {{ $room->room_number }}</a>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight">Edit room {{ $room->room_number }}</h1>
        </div>
    </x-slot>

    <div class="grid max-w-3xl gap-6">
        <x-panel>
            <form action="{{ route('rooms.update', $room) }}" method="POST" class="grid gap-6">
                @csrf
                @method('PUT')
                @include('rooms._form')
                <div class="flex justify-end gap-3">
                    <a href="{{ route('rooms.show', $room) }}" class="rounded-control px-4 py-2.5 text-sm font-medium text-slate hover:text-ink">Cancel</a>
                    <x-primary-button>Save changes</x-primary-button>
                </div>
            </form>
        </x-panel>

        <x-panel title="Remove this room">
            <p class="text-sm text-slate">Only possible when the room has no active bookings. Past bookings keep their record.</p>
            <form action="{{ route('rooms.destroy', $room) }}" method="POST" class="mt-4" x-data @submit.prevent="if (confirm('Delete room {{ $room->room_number }}? This cannot be undone.')) $el.submit()">
                @csrf
                @method('DELETE')
                <x-danger-button>Delete room</x-danger-button>
            </form>
        </x-panel>
    </div>
</x-app-layout>
