<?php

namespace Database\Factories;

use App\Enums\common\ApplicationStatus;
use App\Models\{
    Job,
    User,
};
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'job_id' => Job::factory(),
            'cover_letter' => fake()->text(),
            'status' => collect(ApplicationStatus::cases())->random()->value,
        ];
    }
}
