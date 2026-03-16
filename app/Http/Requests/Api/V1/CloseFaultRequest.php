<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class CloseFaultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('close', $this->route('fault'));
    }

    public function rules(): array
    {
        return [];
    }
}
