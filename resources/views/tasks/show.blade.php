<x-layout :pages="[['title' => 'Task Details', 'href' => '#']]">
    <x-card>
        <x-card-header title="{{ $task->title }}"/>

        <x-tasks.group
            name="Basic Information"
            :fields="[
                ['label' => 'Division', 'value' => $task->division->name],
                ['label' => 'Location', 'value' => $task->location],
                ['label' => 'Created By', 'value' => $task->creator?->name],
                ['label' => 'Created At', 'value' => $task->created_at->format('Y-m-d')],
                ['label' => 'Description', 'value' => $task->description],
            ]"
            :button='true'
            link='/tasks/{{ $task->id }}/edit'
            buttonText='Edit'/>

        <x-tasks.group
            name="Maintenance Information"
            :fields="[
                ['label' => 'Priority', 'value' => $task->priority],
                ['label' => 'Status', 'value' => $task->status],
                ['label' => 'Scheduled Date', 'value' => $task->scheduled_date?->format('Y-m-d')],
                ['label' => 'Assigned To', 'value' => $task->assingee?->name],
                ['label' => 'Assigned By', 'value' => $task->assingedBy?->name],
                ['label' => 'Started At', 'value' => $task->started_at?->format('Y-m-d')],
                ['label' => 'Completed At', 'value' => $task->completed_at?->format('Y-m-d')],
                ['label' => 'Verifed By', 'value' => $task->verified_by?->format('Y-m-d')],
                ['label' => 'remarks', 'value' => $task?->remarks],
            ]"/>
    </x-card>
</x-layout>
