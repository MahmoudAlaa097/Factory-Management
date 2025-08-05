@props(['title', 'type', 'priority', 'status', 'division', 'creator'])

<tr>
    <x-tables.cell>{{ $title }}</x-tables.cell>
    <x-tables.cell>{{ $type }}</x-tables.cell>
    <x-tables.cell>{{ $priority }}</x-tables.cell>
    <x-tables.status :status='$status'/>
    <x-tables.cell> {{ $division }}</x-tables.cell>
    <x-tables.cell>{{ $creator }}</x-tables.cell>
</tr>
