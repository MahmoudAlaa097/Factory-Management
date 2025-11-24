@props(['placeholder' => ''])

<textarea
    {{
        $attributes->merge([
            'class' =>
                'w-full min-h-[120px] rounded-lg bg-card-dark border border-border-light/20
                 dark:border-border-dark/20 dark:bg-card-dark
                 text-foreground-light dark:text-foreground-dark
                 p-4 resize-y focus:ring-2 focus:ring-primary/40 focus:outline-none'
        ])
    }}
    placeholder="{{ $placeholder }}"
></textarea>
