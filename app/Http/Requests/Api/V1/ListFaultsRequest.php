<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ListFaultsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'include'                          => ['sometimes', 'string'],
            'filter.machine_id'                => ['sometimes', 'integer', 'exists:machines,id'],
            'filter.division_id'               => ['sometimes', 'integer', 'exists:divisions,id'],
            'filter.maintenance_management_id' => ['sometimes', 'integer', 'exists:managements,id'],
            'filter.status'                    => ['sometimes', 'string'],
            'filter.reported_by'               => ['sometimes', 'integer', 'exists:employees,id'],
            'sort'                             => ['sometimes', 'string'],
            'per_page'                         => ['sometimes', 'integer', 'min:1', 'max:100'],
        ];
    }
}
