<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => [
                'sometimes',
                'integer',
                'exists:companies,id',
            ],
            'price' => [
                'sometimes',
                'numeric',
                'min:0.1',
                'max:9999999'
            ],
            'weight' => [
                'sometimes',
                'numeric',
                'min:0.1',
                'max:9999'
            ],
            'description' => [
                'nullable',
                'sometimes',
            ],
        ];
    }
}
