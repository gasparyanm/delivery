<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companyVar = Company::FORMULA_VAR;
        $rate = config('app.rates.EUR_TO_USD');
        $costAmount = round(0.33 * $rate, 2);

        Company::factory()
            ->create([
                'name' => 'USP',
                'formula' => "return $companyVar > 4.5 ? 2 : 3;"
            ]);

        Company::factory()
            ->create([
                'name' => 'DHL',
                'formula' => "return round(round($companyVar) * $costAmount / 0.1, 2);"
            ]);
    }
}
