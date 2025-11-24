@props(['placeholder' => ''])

<select
    {{
        $attributes->merge([
            'class' =>
                'w-full h-14 rounded-lg bg-card-dark border border-border-light/20
                 dark:border-border-dark/20 dark:bg-card-dark
                 text-foreground-light dark:text-foreground-dark
                 px-4 focus:ring-2 focus:ring-primary/40 focus:outline-none'
        ])
    }}
>
    @if($placeholder)
        <option value="">{{ $placeholder }}</option>
    @endif

    {{ $slot }}
</select>
