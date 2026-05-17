<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\WorkOrderType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWorkOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $type   = $this->input('type');
        $isTask = $type === WorkOrderType::Task->value;
        $isFaultOrPreventive = in_array($type, [
            WorkOrderType::Fault->value,
            WorkOrderType::Preventive->value,
        ]);

        return [
            'machine_id'       => [
                Rule::requiredIf($isFaultOrPreventive),
                'nullable', 'integer', 'exists:machines,id',
            ],
            'logged_by'        => ['required', 'integer', 'exists:employees,id'],
            'type'             => ['required', Rule::enum(WorkOrderType::class)],
            'date'             => ['required', 'date'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'start_time'       => ['nullable', 'date'],
            'end_time'         => ['nullable', 'date', 'after:start_time'],
            'notes'            => ['nullable', 'string', 'max:2000'],

            'technician_ids'   => ['required', 'array', 'min:1'],
            'technician_ids.*' => ['integer', 'exists:employees,id'],

            // fault
            'affected_components'                => [
                Rule::requiredIf($type === WorkOrderType::Fault->value),
                'nullable', 'array', 'min:1',
            ],
            'affected_components.*.section_id'   => [
                Rule::requiredIf($type === WorkOrderType::Fault->value),
                'integer', 'exists:machine_sections,id',
            ],
            'affected_components.*.component_id' => [
                Rule::requiredIf($type === WorkOrderType::Fault->value),
                'integer', 'exists:machine_components,id',
            ],

            // preventive
            'maintenance_type' => [
                Rule::requiredIf($type === WorkOrderType::Preventive->value),
                'nullable', 'string', 'max:255',
            ],

            // task
            'task_title'     => [Rule::requiredIf($isTask), 'nullable', 'string', 'max:255'],
            'task_tag'       => ['nullable', 'string', 'max:100'],
            'requester_type' => [Rule::requiredIf($isTask), 'nullable', Rule::in(['division', 'management'])],
            'requester_id'   => [Rule::requiredIf($isTask), 'nullable', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'machine_id.required'          => 'Machine is required for fault and preventive work orders.',
            'duration_minutes.required'    => 'Duration is required.',
            'duration_minutes.min'         => 'Duration must be at least 1 minute.',
            'affected_components.required' => 'At least one affected component is required.',
            'technician_ids.min'           => 'At least one technician must be assigned.',
        ];
    }
}
