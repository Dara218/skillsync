<?php

namespace Database\Seeders\InitialDatabaseSeeder;

use App\Models\{
    Job,
    JobTag,
    JobTagJob,
};
use Illuminate\Database\Seeder;

class JobTagJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to prevent duplication
        JobTagJob::truncate();

        $count = config('constants.default_seeder_count');

        // Create a JobTagJob data with a random valid job_id and job_tag_id
        JobTagJob::factory($count)
            ->create(fn () => [
                'job_id' => Job::inRandomOrder()->value('id'),
                'job_tag_id' => JobTag::inRandomOrder()->value('id'),
            ]);
    }
}
