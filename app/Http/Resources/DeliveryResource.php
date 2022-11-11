<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'company' => $this->company->name,
            'weight' => $this->weight . ' Kg.',
            'price' => $this->price . ' USD',
            'deliveryCost' => $this->deliveryCost . ' USD',
            'total' => ($this->price + $this->deliveryCost) . ' USD',
            'description' => $this->description,
        ];
    }
}
