<?php

namespace Database\Seeders\InitialDatabaseSeeder;

use App\Models\JobTag;
use Illuminate\Database\Seeder;

class JobTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to prevent duplicate
        JobTag::truncate();

        $tags = [
            ['name' => 'Remote'],
            ['name' => 'Full-time'],
            ['name' => 'Part-time'],
            ['name' => 'Freelance'],
            ['name' => 'Internship'],
            ['name' => 'On-site'],
            ['name' => 'Contract'],
            ['name' => 'Entry Level'],
            ['name' => 'Senior Level'],
            ['name' => 'Flexible Hours'],
        ];

        $count = count($tags);

        JobTag::factory($count)
            ->sequence(...$tags)
            ->create();
    }
}
