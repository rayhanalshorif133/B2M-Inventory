<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userSeeder = new UserSeeder();
        $userSeeder->run();

        $userLogSeeder = new UserLogsSeeder();
        $userLogSeeder->run();

        $visitLogDetailSeeder = new VisitLogDetailSeeder();
        $visitLogDetailSeeder->run();
    }
}
