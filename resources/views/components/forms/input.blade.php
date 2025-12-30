@props([
    'type' => 'text',
    'placeholder' => '',
    'value' => ''
])

<input
    type="{{ $type }}"
    placeholder="{{ $placeholder }}"
    value="{{ $value }}"
    {{ $attributes->merge([
        'class' => 'w-full h-14 rounded-lg bg-card-dark border border-border-light/20
                    dark:border-border-dark/20 dark:bg-card-dark
                    text-foreground-light dark:text-foreground-dark
                    px-4 focus:ring-2 focus:ring-primary/40 focus:outline-none
                    disabled:opacity-50 disabled:cursor-not-allowed'
    ]) }}
/>
