<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class visaSeeder extends Seeder
{
    public function run(): void
    {
        $visa = [
            ['visa' => 'bussines', 'status' => 'active', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
            ['visa' => 'travel', 'status' => 'active', 'created_at' => date("Y-m-d H:i:s"), 'updated_at' => date("Y-m-d H:i:s")],
        ];

        DB::table('visa')->insert($visa);
    }
}
