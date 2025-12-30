<div>
    <form wire:submit.prevent="submit">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Division Select --}}
            <x-forms.dependent-select
                label="Division"
                name="division_id"
                wireModel="division_id"
                :options="$productionDivisions->toArray()"
                :is-loading="$isLoadingMachines"
                placeholder="Select Division"
                :required="true"
            />

            {{-- Machine Select --}}
            <x-forms.dependent-select
                label="Machine"
                name="machine_id"
                wireModel="machine_id"
                :options="$machines"
                :is-loading="$isLoadingMachines"
                :disabled="empty($division_id)"
                :dependency-message="empty($division_id) ? 'Select a division first' : null"
                placeholder="Select Machine"
                wire-target="loadMachines"
                :required="true"
            />

            {{-- Fault Type Select --}}
            <x-forms.group label="Fault Type">
                <x-forms.select wire:model="fault_type" name="fault_type" required>
                    <option value="">Select Fault Type</option>
                    <option value="electrical">Electrical</option>
                    <option value="mechanical">Mechanical</option>
                    <option value="both">Both</option>
                </x-forms.select>
            </x-forms.group>

            {{-- Machine Section Select --}}
            <x-forms.dependent-select
                label="Machine Section"
                name="section_id"
                wireModel="section_id"
                :options="$sections"
                :is-loading="$isLoadingSections"
                :disabled="empty($machine_id)"
                :dependency-message="empty($machine_id) ? 'Select a machine first' : null"
                placeholder="Select Section"
                wire-target="loadMachineSections"
                :required="false"
            />

            {{-- Description Textarea --}}
            <x-forms.group label="Description" class="md:col-span-2">
                <textarea
                    wire:model="description"
                    name="description"
                    rows="4"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Describe the fault in detail..."
                ></textarea>

                @error('description')
                    <span class="mt-1 text-sm text-red-600">{{ $message }}</span>
                @enderror
            </x-forms.group>
        </div>

        {{-- Errors --}}
        @error('submit')
            <div class="mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ $message }}
            </div>
        @enderror

        {{-- Action Buttons --}}
        <div class="mt-6 flex justify-end gap-4">
            <x-forms.button
                variant="secondary"
                type="button"
                onclick="window.history.back()"
            >
                Cancel
            </x-forms.button>

            <x-forms.button
                variant="primary"
                type="submit"
                :disabled="empty($machine_id)"
            >
                <span wire:loading wire:target="submit" class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Submitting...
                </span>
                <span wire:loading.remove wire:target="submit">
                    Submit Fault
                </span>
            </x-forms.button>
        </div>
    </form>
</div>
