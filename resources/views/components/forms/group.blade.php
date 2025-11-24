@props(['label' => null])

<div class="flex flex-col space-y-2">
    @if($label)
        <p class="text-foreground-light/80 dark:text-foreground-dark/80 font-medium">
            {{ $label }}
        </p>
    @endif

    {{ $slot }}
</div>
