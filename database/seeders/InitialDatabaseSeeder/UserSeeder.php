<?php

namespace Database\Seeders\InitialDatabaseSeeder;

use App\Enums\common\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to prevent duplication
        User::truncate();

        $users = [
            // Create User
            [
                'name' => 'Test name',
                'email' => 'user@example.com',
                'password' => bcrypt('Qwerty123@'),
                'user_role' => UserRole::JOB_SEEKER->value,
                'resume_path' => 'resume/test_resume.pdf',
                'email_verified_at' => now(),
            ],
            // Create Admin
            [
                'name' => 'Test admin name',
                'email' => 'admin@example.com',
                'password' => bcrypt('Qwerty123@'),
                'user_role' => UserRole::ADMIN->value,
                'resume_path' => null,
                'email_verified_at' => now(),
            ],
        ];

        $count = count($users);

        User::factory($count)
            ->sequence(...$users)
            ->create();
    }
}
