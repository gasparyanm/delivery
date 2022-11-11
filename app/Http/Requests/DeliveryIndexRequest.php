<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryIndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'companyId' => [
                'nullable',
                'integer',
                'exists:companies,id',
            ],
            'companyName' => [
                'nullable',
                'string',
                'min:3',
            ],
            'minWeight' => [
                'nullable',
                'numeric',
                'min:0.1',
                'max:9999',
                'required_with:maxWeight',
                'lte:maxWeight',
            ],
            'maxWeight' => [
                'nullable',
                'numeric',
                'min:0.1',
                'max:9999',
                'required_with:minWeight',
                'gte:minWeight',
            ],
            'minPrice' => [
                'nullable',
                'numeric',
                'min:0.1',
                'max:9999999',
                'required_with:maxPrice',
                'lte:maxPrice',
            ],
            'maxPrice' => [
                'nullable',
                'numeric',
                'min:0.1',
                'max:9999999',
                'required_with:minPrice',
                'gte:minPrice',
            ],
            'minDeliveryCost' => [
                'nullable',
                'numeric',
                'required_with:maxDeliveryCost',
                'lte:maxDeliveryCost',
            ],
            'maxDeliveryCost' => [
                'nullable',
                'numeric',
                'required_with:minDeliveryCost',
                'gte:minDeliveryCost',
            ],
            'description' => [
                'nullable',
                'string',
            ]
        ];
    }
}
