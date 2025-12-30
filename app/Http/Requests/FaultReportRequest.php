<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaultReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'division_id' => 'required|exists:divisions,id',
            'machine_id' => 'required|exists:machines,id',
            'machine_section_id' => 'nullable|exists:machine_sections,id',
            'fault_type' => 'required|in:mechanical,electrical,other',
            'description' => 'nullable|string|min:10|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'description.min' => 'Please provide at least 10 characters describing the fault.',
            'fault_type.required' => 'Please select a fault type.',
            'division_id.required' => 'Please select a division.',
            'machine_id.required' => 'Please select a machine.',
        ];
    }

    public function attributes(): array
    {
        return [
            'division_id' => 'division',
            'machine_id' => 'machine',
            'machine_section_id' => 'machine section',
            'fault_type' => 'fault type',
        ];
    }
}
