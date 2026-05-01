<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaultResolutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('updateResolution', $this->route('fault'));
    }

    public function rules(): array
    {
        return [
            'resolution_notes'       => ['sometimes', 'nullable', 'string', 'max:2000'],
            'time_consumed'          => ['sometimes', 'nullable', 'integer', 'min:1'],

            'components'             => ['sometimes', 'array'],
            'components.*.id'        => ['required', 'integer', 'exists:fault_components,id'],
            'components.*.notes'     => ['sometimes', 'nullable', 'string', 'max:500'],
        ];
    }
}
