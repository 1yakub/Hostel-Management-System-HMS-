<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold tracking-tight">Guests</h1>
        <a href="{{ route('guests.create') }}" class="rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">Register guest</a>
    </x-slot>

    @if ($guests->isEmpty())
        <x-empty-state title="No guests on file" action="Register the first guest" :href="route('guests.create')">Every desk booking needs a registered guest with an ID number.</x-empty-state>
    @else
        <x-panel class="p-0 md:p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate">
                        <tr class="border-b border-rule">
                            <th class="px-5 py-3 font-medium">Name</th>
                            <th class="px-5 py-3 font-medium">Phone</th>
                            <th class="px-5 py-3 font-medium">ID number</th>
                            <th class="px-5 py-3 font-medium">Registered</th>
                            <th class="px-5 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-rule">
                        @foreach ($guests->sortBy('name') as $guest)
                            <tr class="hover:bg-chalk">
                                <td class="px-5 py-3 font-medium"><a href="{{ route('guests.show', $guest) }}" class="hover:text-fern-600">{{ $guest->name }}</a></td>
                                <td class="px-5 py-3">{{ $guest->phone }}</td>
                                <td class="px-5 py-3 font-mono text-xs">{{ $guest->id_number }}</td>
                                <td class="px-5 py-3 whitespace-nowrap text-slate">{{ $guest->created_at->format('j M Y') }}</td>
                                <td class="px-5 py-3 text-right"><a href="{{ route('guests.edit', $guest) }}" class="text-slate hover:text-fern-600">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-panel>
    @endif
</x-app-layout>
