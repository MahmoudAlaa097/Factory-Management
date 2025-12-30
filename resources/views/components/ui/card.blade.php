@props(['title' => 'Card Title', 'value' => '0', 'change' => '0%'])

<div class="bg-card-light dark:bg-card-dark p-6 rounded-lg shadow">
    <p class="text-base font-medium text-foreground-light/80 dark:text-foreground-dark/80">
        {{ $title }}
    </p>
    <p class="text-3xl font-bold my-1">{{ $value }}</p>
    <p class="text-base font-medium text-success-light dark:text-success-dark">
        {{ $change }}
    </p>
</div>
