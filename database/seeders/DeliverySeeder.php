<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Delivery;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    public function run(): void
    {
        $companyIds = Company::all()->pluck('id');

        Delivery::factory()
            ->count(10)
            ->state(new Sequence(
                function () use ($companyIds) {
                    return ['company_id' => $companyIds->random()];
                },
            ))
            ->create();
    }
}
