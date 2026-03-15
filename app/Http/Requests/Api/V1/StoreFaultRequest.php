<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\ManagementType;
use App\Models\Management;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Fault;

class StoreFaultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('store', Fault::class);
    }

    public function rules(): array
    {
        $productionId = Management::where('type', ManagementType::Production)->value('id');

        return [
            'machine_id'                => ['required', 'integer', 'exists:machines,id'],
            'maintenance_management_id' => [
                'required',
                'integer',
                'exists:managements,id',
                Rule::notIn([$productionId]),
            ],
            'description'               => ['required', 'string', 'min:10'],
        ];
    }

    public function messages(): array
    {
        return [
            'maintenance_management_id.not_in' => 'You must select a maintenance management, not production.',
        ];
    }
}
