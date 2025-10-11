@props(['icon'])
<svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
    @if ($icon === 'sun')
        <x-sidebar.icon icon="sun" />
    @elseif ($icon === 'moon')
        <x-sidebar.icon icon="moon" />
    @endif
</svg>
