<?php

namespace Database\Factories;

use App\Enums\common\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => bcrypt('Qwerty123@'),
            'user_role' => collect(UserRole::cases())->random()->value,
            'resume_path' => fake()->filePath(),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ];
    }
}
