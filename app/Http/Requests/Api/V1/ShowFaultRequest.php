<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ShowFaultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('view', $this->route('fault'));
    }

    public function rules(): array
    {
        return [];
    }
}
