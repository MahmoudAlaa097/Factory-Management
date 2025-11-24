<x-layout title="Create Fault Request">
    <form method="POST" action="">
        @csrf

        <div x-data="faultForm()" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Division Select -->
            <x-forms.group label="Division">
                <x-forms.select
                    x-model="selectedDivision"
                    @change="fetchMachines()"
                    name="division_id"
                >
                    <option value="">Select Division</option>
                    @foreach($productionDivisions as $division)
                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                    @endforeach
                </x-forms.select>
            </x-forms.group>

            <!-- Machine Select -->
            <x-forms.group label="Machine">
                <x-forms.select
                    x-model="selectedMachine"
                    x-bind:disabled="machines.length === 0"
                    name="machine_id"
                >
                    <option value="">Select Machine</option>
                    <template x-for="machine in machines" :key="machine.id">
                        <option :value="machine.id" x-text="machine.number"></option>
                    </template>
                </x-forms.select>
            </x-forms.group>

        </div>

        <!-- Buttons -->
        <div class="mt-4 flex justify-end gap-4">
            <x-forms.button variant="secondary" type="button">Cancel</x-forms.button>
            <x-forms.button variant="primary" type="submit">Submit Fault</x-forms.button>
        </div>
    </form>
</x-layout>
