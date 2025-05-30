<?php

namespace Database\Factories;

use App\Enums\common\JobType;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'title' => fake()->title(),
            'location' => fake()->address(),
            'type' => collect(JobType::cases())->random()->value,
            'salary_range' => fake()->randomNumber(),
            'description' => fake()->text(),
            'is_published' => fake()->boolean(),
            'published_at' => now(),
        ];
    }
}
