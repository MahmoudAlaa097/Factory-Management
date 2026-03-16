<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ListComponentReplacementsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'include'              => ['sometimes', 'string'],
            'filter.fault_id'      => ['sometimes', 'integer', 'exists:faults,id'],
            'filter.machine_id'    => ['sometimes', 'integer', 'exists:machines,id'],
            'filter.old_component_id' => ['sometimes', 'integer', 'exists:machine_components,id'],
            'filter.new_component_id' => ['sometimes', 'integer', 'exists:machine_components,id'],
            'sort'                 => ['sometimes', 'string'],
            'per_page'             => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
