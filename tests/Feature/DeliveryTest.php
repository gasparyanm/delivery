<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Delivery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeliveryTest extends TestCase
{
    use RefreshDatabase;

    public function testGetDeliveriesSuccess()
    {
        Delivery::factory()->count(15)->create();

        $response = $this->getJson(route('deliveries.index'));

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(15, 'data');
    }

    public function testGetDeliveriesError()
    {
        Delivery::factory()->count(15)->create();

        $requestData = Delivery::factory()->make()->toArray();
        $requestData['companyId'] = 9999;

        $response = $this->getJson(route('deliveries.index', $requestData));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "companyId",
                ]
            ]);
    }

    public function testStoreDeliverySuccess()
    {
        $company = Company::factory()->create();

        $requestData = [
            "companyId" => $company->id,
            "price" => 100.25,
            "weight" => 4.85,
        ];

        $response = $this->postJson(route('deliveries.store', $requestData));

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testStoreDeliveryError()
    {
        $requestData = [
            "companyId" => 9999,
            "price" => 100.25,
            "weight" => 4.85,
        ];

        $response = $this->postJson(route('deliveries.store', $requestData));

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "companyId",
                ]
            ]);
    }

    public function testUpdateDeliverySuccess()
    {
        $delivery = Delivery::factory()->create();

        $company = Company::factory()->create();
        $requestData = Delivery::factory()
            ->for($company)
            ->make()->toArray();

        $response = $this->putJson(route('deliveries.update', $delivery), $requestData);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUpdateDeliveryError()
    {
        $delivery = Delivery::factory()->create();

        $requestData = Delivery::factory()->make()->toArray();
        $requestData['companyId'] = 9999;

        $response = $this->putJson(route('deliveries.update', $delivery), $requestData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonStructure([
                "message",
                "errors" => [
                    "companyId",
                ]
            ]);
    }
}
