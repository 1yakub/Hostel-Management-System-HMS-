<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center gap-2 rounded-control border border-danger/30 bg-white px-4 py-2.5 text-sm font-medium text-danger hover:bg-red-50 disabled:opacity-50']) }}>
    {{ $slot }}
</button>
