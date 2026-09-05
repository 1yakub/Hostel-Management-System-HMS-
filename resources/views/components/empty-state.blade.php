@props(['title', 'action' => null, 'href' => null])

<div class="rounded-photo border border-dashed border-rule bg-chalk p-8 text-center">
    <p class="font-medium">{{ $title }}</p>
    <p class="mt-1 text-sm text-slate">{{ $slot }}</p>
    @if ($action && $href)
        <a href="{{ $href }}" class="mt-4 inline-flex rounded-control bg-ink px-4 py-2 text-sm font-medium text-chalk hover:bg-ink-2">{{ $action }}</a>
    @endif
</div>
