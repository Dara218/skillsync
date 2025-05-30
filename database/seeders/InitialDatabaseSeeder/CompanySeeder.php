<?php

namespace Database\Seeders\InitialDatabaseSeeder;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to prevent duplication
        Company::truncate();

        $count = config('constants.default_seeder_count');

        Company::factory($count)->create();
    }
}
