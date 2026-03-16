<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class ApproveMaintenanceFaultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('approve', $this->route('fault'));
    }

    public function rules(): array
    {
        return [];
    }
}
