@props([
    'type' => 'button',
    'variant' => 'primary', // primary, secondary, danger, ghost
    'size' => 'md'
])

@php
    $variants = [
        'primary' => 'bg-primary hover:bg-primary/90 text-white',
        'secondary' => 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-900 dark:text-white',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'ghost' => 'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-800 text-foreground-light dark:text-foreground-dark',
    ];

    $sizes = [
        'sm' => 'px-3 py-2 text-sm h-10',
        'md' => 'px-4 py-2.5 text-base h-12',
        'lg' => 'px-6 py-3 text-lg h-14',
    ];
@endphp

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => "rounded-lg font-medium transition-colors focus:outline-none focus:ring-2
                    focus:ring-primary/40 disabled:opacity-50 disabled:cursor-not-allowed
                    {$variants[$variant]} {$sizes[$size]}"
    ]) }}
>
    {{ $slot }}
</button>
