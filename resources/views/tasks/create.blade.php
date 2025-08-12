<x-layout :pages="[['title' => 'Create Task', 'href' => '/tasks/create']]">
    <x-card>
        <x-card-header title="Create Task"/>

        <x-forms.form action="/tasks/store" method="POST">
            <div class="grid grid-cols-1 gap-5">
                <!-- Title -->
                <x-forms.input label="Title" name="title" required/>

                <!-- Description -->
                <x-forms.input label="Description"/>

                <!-- Priority -->
                <x-forms.select
                    label="Priority"
                    name="priority"
                    :items="[
                        ['value' => '', 'name' => 'Select Priority'],
                        ['value' => 'low', 'name' => 'Low'],
                        ['value' => 'medium', 'name' => 'Medium'],
                        ['value' => 'high', 'name' => 'High'],
                        ['value' => 'urgent', 'name' => 'Urgent']
                    ]"
                    required/>

                <!-- Division -->
                <x-forms.select
                    label="Division"
                    name="division_id"
                    :items="$divisions"
                    :selected="$task->division_id ?? null"
                    required/>

                <!-- Location -->
                <x-forms.input label="Location" name="location" required/>

                <!-- Scheduled Date -->
                <x-forms.input label="Scheduled Date" name="scheduled_date" type='date'/>
            </div>

            <!-- Submit Button -->
            <x-buttons.button type="submit">Submit</x-buttons.button>
        </x-forms.form>
    </x-card>
</x-layout>
