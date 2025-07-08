<?php

namespace Database\Seeders\InitialDatabaseSeeder;

use App\Models\UserSignupCode;
use Illuminate\Database\Seeder;

class UserSiguUpCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to prevent duplication
        UserSignupCode::truncate();

        UserSignupCode::factory()->create([
            'email' => 'test@example.com',
        ]);
    }
}
