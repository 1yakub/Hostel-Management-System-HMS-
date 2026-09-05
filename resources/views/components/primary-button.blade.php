<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-control bg-ink px-4 py-2.5 text-sm font-medium text-chalk hover:bg-ink-2 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
