@props(['variant' => 'primary'])

@php
$classes = match($variant) {
    'primary' =>
        'bg-primary text-white hover:bg-primary/80',
    'secondary' =>
        'bg-card-dark text-foreground-light dark:bg-card-dark dark:text-foreground-dark hover:bg-card-light/20',
    default =>
        'bg-primary text-white'
};
@endphp

<button
    {{
        $attributes->merge([
            'class' =>
                "px-6 py-3 rounded-lg font-semibold transition-colors duration-200 $classes"
        ])
    }}
>
    {{ $slot }}
</button>
