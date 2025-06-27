@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'border-luxury-200 dark:border-luxury-700 bg-white/50 dark:bg-gray-900/50 text-luxury-900 dark:text-luxury-100 focus:border-luxury-500 dark:focus:border-luxury-600 focus:ring-luxury-500 dark:focus:ring-luxury-600 rounded-lg shadow-sm transition-colors',
]) !!}>
