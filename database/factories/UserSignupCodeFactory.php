<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSignupCode>
 */
class UserSignupCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $registerCodeLength = config('constants.user_register_code_length');

        return [
            'email' => fake()->unique()->safeEmail(),
            'code' => Str::random($registerCodeLength),
        ];
    }
}
