<?php

namespace Database\Seeders;

use Database\Seeders\InitialDatabaseSeeder\{
    ApplicationSeeder,
    CompanySeeder,
    JobSeeder,
    JobTagJobSeeder,
    JobTagSeeder,
    UserSeeder,
};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            // CompanySeeder::class, Comment out; JobSeeder creates Company
            JobSeeder::class,
            JobTagSeeder::class,
            ApplicationSeeder::class,
            JobTagJobSeeder::class,
        ]);
    }
}
