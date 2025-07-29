@props([ 'headings' => []])

<thead>
    <tr class="border-b border-gray-100 dark:border-gray-800">
        @foreach ($headings as $heading)
            <x-tables.heading>{{ $heading }}</x-tables.heading>
        @endforeach
    </tr>
</thead>
