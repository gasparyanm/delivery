<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryIndexRequest;
use App\Http\Requests\DeliveryStoreRequest;
use App\Http\Requests\DeliveryUpdateRequest;
use App\Http\Resources\DeliveryCollection;
use App\Http\Resources\DeliveryResource;
use App\Models\Delivery;
use App\Services\DeliveryService;

class DeliveryController extends Controller
{
    public function index(
        DeliveryIndexRequest $deliveryIndexRequest,
        DeliveryService $deliveryService
    ): DeliveryCollection {
        $deliveries = $deliveryService->search($deliveryIndexRequest->validated());

        return new DeliveryCollection($deliveries);
    }

    public function store(DeliveryStoreRequest $deliveryStoreRequest): DeliveryResource
    {
        $delivery =  Delivery::create($deliveryStoreRequest->validated());

        return new DeliveryResource($delivery);
    }

    public function update(
        DeliveryUpdateRequest $deliveryUpdateRequest,
        Delivery $delivery
    ): DeliveryResource {
        $delivery->fill($deliveryUpdateRequest->validated())->save();

        return new DeliveryResource($delivery);
    }
}
