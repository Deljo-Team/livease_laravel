<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class genderSeeder extends Seeder
{
    public function run(): void
    {
        $gender = [
            ['gender' => 'male', 'status' => 'active', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['gender' => 'female', 'status' => 'active', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
        ];

        DB::table('gender')->insert($gender);
    }
}
