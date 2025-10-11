<?php

namespace App\Services;

class FixingRequestFormService
{
    // Helper method to prepend a default option to a collection
    private function withDefaultOption($collection, string $label = 'Select Option'): array
    {
        return ['' => $label] + $collection;
    }

    // Method to get all form data with default options 
    public function getFormData(): array
    {
        return [
            'divisions'            => $this->withDefaultOption(Division::pluck('name', 'id'), 'Select Division'),
            'machines'             => $this->withDefaultOption(Machine::pluck('number', 'id'), 'Select Machine'),
            'technicians'          => $this->withDefaultOption(
                User::where('role', 'technician')->pluck('name', 'id'),
                'Select Technician'
            ),
            'machine_parts'        => $this->withDefaultOption(MachinePart::pluck('part', 'id'), 'Select Machine Part'),
            'machine_malfunctions' => $this->withDefaultOption(MachineMalfunction::pluck('malfunction', 'id'), 'Select Machine Malfunction'),
        ];
    }
}
