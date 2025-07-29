@props(['user', 'project', 'team', 'status', 'budget'])

<tr>
    <x-tables.cell>{{ $user }}</x-tables.cell>
    <x-tables.cell>{{ $project }}</x-tables.cell>
    <x-tables.cell>{{ $team }}</x-tables.cell>
    <x-tables.status :status='$status'/>
    <x-tables.cell> {{ $budget }}</x-tables.cell>
</tr>
