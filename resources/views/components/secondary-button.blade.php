<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center gap-2 rounded-control border border-rule bg-white px-4 py-2.5 text-sm font-medium text-ink hover:bg-chalk-2 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
