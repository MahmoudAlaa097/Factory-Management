<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaultComponentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('manageComponents', $this->route('fault'));
    }

    public function rules(): array
    {
        return [
            'machine_component_id' => [
                'required',
                'integer',
                'exists:machine_components,id',
            ],
            'notes' => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }
}
