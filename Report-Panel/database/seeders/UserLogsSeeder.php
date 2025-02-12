<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserLog;

class UserLogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLog::create([
            'name' => 'John Doe',
            'msisdn' => '1234567890',
            'email' => 'johndoe@example.com',
            'created_date' => now()->toDateString(),
            'created_time' => now()->toTimeString(),
            'last_login_date' => now()->toDateString(),
            'last_login_time' => now()->toTimeString(),
        ]);

        UserLog::create([
            'name' => 'Mr xyz',
            'msisdn' => '23237890',
            'email' => 'xyz@example.com',
            'created_date' => now()->toDateString(),
            'created_time' => now()->toTimeString(),
            'last_login_date' => now()->toDateString(),
            'last_login_time' => now()->toTimeString(),
        ]);
    }
}
