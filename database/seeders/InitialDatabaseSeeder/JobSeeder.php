<?php

namespace Database\Seeders\InitialDatabaseSeeder;

use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to prevent duplicate
        Job::truncate();

        $count = config('constants.default_seeder_count');

        Job::factory($count)->create();
    }
}
