<?php

namespace Database\Factories;

use App\Models\{
    Job,
    JobTag,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JobTagJob>
 */
class JobTagJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'job_id' => Job::factory(),
            'job_tag_id' => JobTag::factory(),
        ];
    }
}
