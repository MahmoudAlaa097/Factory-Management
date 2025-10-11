@props(['name', 'icon', 'route' => '#'])

@php
    $isActive = Route::is($route . '*');
@endphp

<a href="{{ route($route) }}"
    class="flex items-center gap-3 px-4 py-2 rounded-lg transition
           {{ $isActive ? 'bg-primary text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800' }}">
    <x-layout.sidebar.icon :icon="$icon" />
    <span class="font-medium">{{ $name }}</span>
</a>
