<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'inline-flex items-center px-6 py-3 bg-gradient-to-r from-luxury-600 to-accent-600 hover:from-luxury-700 hover:to-accent-700 active:from-luxury-800 active:to-accent-800 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-luxury-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-300 shadow-luxury hover:shadow-luxury-lg',
    ]) }}>
    {{ $slot }}
</button>
