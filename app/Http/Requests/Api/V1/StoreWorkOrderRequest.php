<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\WorkOrderType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // plug in your gate logic here
    }

    public function rules(): array
    {
        $type = $this->input('type');

        return [
            // ── Base ────────────────────────────────────────────
            'machine_id'      => ['required', 'integer', 'exists:machines,id'],
            'logged_by'       => ['required', 'integer', 'exists:employees,id'],
            'type'            => ['required', Rule::enum(WorkOrderType::class)],
            'start_time'      => ['required', 'date'],
            'end_time'        => ['nullable', 'date', 'after:start_time'],
            'notes'           => ['nullable', 'string', 'max:2000'],

            // ── Technicians ─────────────────────────────────────
            'technician_ids'              => ['required', 'array', 'min:1'],
            'technician_ids.*'            => ['integer', 'exists:employees,id'],

            // ── Fault ───────────────────────────────────────────
            'affected_components'         => [
                Rule::requiredIf($type === WorkOrderType::Fault->value),
                'array',
                'min:1',
            ],
            'affected_components.*.section_id'   => [
                Rule::requiredIf($type === WorkOrderType::Fault->value),
                'integer',
                'exists:machine_sections,id',
            ],
            'affected_components.*.component_id' => [
                Rule::requiredIf($type === WorkOrderType::Fault->value),
                'integer',
                'exists:machine_components,id',
            ],

            // ── Preventive ──────────────────────────────────────
            'maintenance_type' => [
                Rule::requiredIf($type === WorkOrderType::Preventive->value),
                'nullable',
                'string',
                'max:255',
            ],
            'is_finished'      => [
                Rule::requiredIf($type === WorkOrderType::Preventive->value),
                'nullable',
                'boolean',
            ],

            // ── Task ────────────────────────────────────────────
            'task_title'  => [
                Rule::requiredIf($type === WorkOrderType::Task->value),
                'nullable',
                'string',
                'max:255',
            ],
            'division_id' => [
                Rule::requiredIf($type === WorkOrderType::Task->value),
                'nullable',
                'integer',
                'exists:divisions,id',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'affected_components.required' => 'At least one affected component is required for fault work orders.',
            'technician_ids.min'           => 'At least one technician must be assigned.',
        ];
    }
}
