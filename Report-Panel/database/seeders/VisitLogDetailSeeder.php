<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisitLogDetail;

class VisitLogDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VisitLogDetail::create([
            'visitor_id' => 'V12345',
            'page_name' => 'Home Page',
            'open_time' => now()->toTimeString(),
            'close_time' => now()->addMinutes(5)->toTimeString(),
            'duration' => '5 minutes',
            'page_url' => 'https://example.com/home',
        ]);

        VisitLogDetail::create([
            'visitor_id' => 'V67890',
            'page_name' => 'Contact Us',
            'open_time' => now()->toTimeString(),
            'close_time' => now()->addMinutes(3)->toTimeString(),
            'duration' => '3 minutes',
            'page_url' => 'https://example.com/contact',
        ]);
    }
}
