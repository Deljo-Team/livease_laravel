<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class jobSeeder extends Seeder
{
    public function run(): void
    {
        $job = [
            ['job' => 'software developer', 'status' => 'active', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['job' => 'tester', 'status' => 'active', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
        ];

        DB::table('job')->insert($job);
    }
}
