<x-layout :pages="[['title' => 'Tasks', 'href' => '/tasks']]">
    <x-card>
        <x-card-header title="Tasks">
            <a href="tasks/create">
                <x-buttons.button>Create Task</x-buttons.button>
            </a>
        </x-card-header>

        <div class="p-5 border-t border-gray-100 dark:border-gray-800 sm:p-6">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
                <div class="max-w-full overflow-x-auto">
                    <table class="min-w-full">
                        <x-tables.header :headings="['Title', 'Type', 'Priority', 'Status', 'Division', 'Creator', 'Assignee']"/>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($tasks as $task)
                                <x-tables.row :task="$task"/>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-2 mt-4 text-sm font-medium">
                @for ($i = 1; $i <= $tasks->lastPage(); $i++)
                    <a href="{{ $tasks->url($i) }}"
                    class="px-3 py-1 rounded-full border transition
                            {{ $tasks->currentPage() == $i
                                ? 'bg-blue-600 text-white border-blue-600'
                                : 'bg-gray text-gray-700 border-gray-300 hover:bg-gray-100' }}">
                        {{ $i }}
                    </a>
                @endfor
            </div>
        </div>
    </x-card>
</x-layout>
