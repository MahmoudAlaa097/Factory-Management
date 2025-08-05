@props(['title' => ''])

<div class="flex items-center justify-between px-5 py-4 sm:px-6 sm:py-5">
    <x-tables.title>{{ $title }}</x-tables.title>

    {{ $slot }}
</div>
