@props(['task'])

<tr>
    <x-tables.cell><a href="/tasks/ {{ $task->id }}">{{ $task->title }}</a></x-tables.cell>
    <x-tables.cell>{{ $task->type }}</x-tables.cell>
    <x-tables.cell>{{ $task->priority }}</x-tables.cell>
    <x-tables.status :status='$task->status'/>
    <x-tables.cell> {{ $task->division->name }}</x-tables.cell>
    <x-tables.cell>{{ $task->creator->name }}</x-tables.cell>
</tr>
