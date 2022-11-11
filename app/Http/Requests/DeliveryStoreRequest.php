<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => [
                'required',
                'integer',
                'exists:companies,id',
            ],
            'price' => [
                'required',
                'numeric',
                'min:0.1',
                'max:9999999'
            ],
            'weight' => [
                'required',
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
