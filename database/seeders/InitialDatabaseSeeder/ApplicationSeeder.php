<?php

namespace Database\Seeders\InitialDatabaseSeeder;

use App\Enums\common\ApplicationStatus;
use App\Enums\common\UserRole;
use App\Models\{
    Application,
    Job,
    User,
};
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the table to prevent duplicate
        Application::truncate();

        $job = job::factory();

        $user = User::factory([
            'user_role' => UserRole::JOB_SEEKER->value,
        ]);

        $applications = [
            // With Pending application status
            [
                'user_id' => $user,
                'job_id' => $job,
                'cover_letter' => 'Test cover letter',
                'status' => ApplicationStatus::PENDING,
            ],
            // With Reviewed application status
            [
                'user_id' => $user,
                'job_id' => $job,
                'cover_letter' => 'Test cover letter',
                'status' => ApplicationStatus::REVIEWED,
            ],
            // With Accepted application status
            [
                'user_id' => $user,
                'job_id' => $job,
                'cover_letter' => 'Test cover letter',
                'status' => ApplicationStatus::ACCEPTED,
            ],
            // With Rejected application status
            [
                'user_id' => $user,
                'job_id' => $job,
                'cover_letter' => 'Test cover letter',
                'status' => ApplicationStatus::REJECTED,
            ],
        ];

        $count = count($applications);

        Application::factory($count)
            ->sequence(...$applications)
            ->create();
    }
}
