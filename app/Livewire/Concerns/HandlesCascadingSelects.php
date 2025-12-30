<?php

namespace App\Livewire\Concerns;

trait HandlesCascadingSelects
{
    public function updatedDivisionId($value)
    {
        $this->reset(['machine_id', 'machine_section_id', 'machines', 'sections']);

        if ($value) {
            $this->loadMachines();
        }
    }

    public function updatedMachineId($value)
    {
        $this->reset(['machine_section_id', 'sections']);

        if ($value) {
            $this->loadMachineSections();
        }
    }

    protected function restoreOldInput()
    {
        $this->division_id = old('division_id', '');
        $this->machine_id = old('machine_id', '');
        $this->machine_section_id = old('machine_section_id', '');
        $this->fault_type = old('fault_type', '');
        $this->description = old('description', '');
    }

    protected function loadInitialData()
    {
        if ($this->division_id) {
            $this->loadMachines();
        }

        if ($this->machine_id) {
            $this->loadMachineSections();
        }
    }
}
