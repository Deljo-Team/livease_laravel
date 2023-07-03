<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'United States', 'code' => 'US', 'phone_code' => '+1'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'phone_code' => '+44'],
            ['name' => 'Canada', 'code' => 'CA', 'phone_code' => '+1'],
            ['name' => 'India', 'code' => 'IN', 'phone_code' => '+91'],
            ['name' => 'Saudi Arabia', 'code' => 'SA', 'phone_code' => '+966'],
            ['name' => 'United Arab Emirates', 'code' => 'AE', 'phone_code' => '+971'],
            ['name' => 'Qatar', 'code' => 'QA', 'phone_code' => '+974'],
            ['name' => 'Kuwait', 'code' => 'KW', 'phone_code' => '+965'],
            ['name' => 'Oman', 'code' => 'OM', 'phone_code' => '+968'],
            ['name' => 'Bahrain', 'code' => 'BH', 'phone_code' => '+973'],
            ['name' => 'Singapore', 'code' => 'SG', 'phone_code' => '+65'],
            ['name' => 'Malaysia', 'code' => 'MY', 'phone_code' => '+60'],
            ['name' => 'Australia', 'code' => 'AU', 'phone_code' => '+61'],
            ['name' => 'New Zealand', 'code' => 'NZ', 'phone_code' => '+64'],
            ['name' => 'Germany', 'code' => 'DE', 'phone_code' => '+49'],
            ['name' => 'France', 'code' => 'FR', 'phone_code' => '+33'],
            ['name' => 'Spain', 'code' => 'ES', 'phone_code' => '+34'],
            ['name' => 'Italy', 'code' => 'IT', 'phone_code' => '+39'],
            ['name' => 'China', 'code' => 'CN', 'phone_code' => '+86'],
            ['name' => 'Japan', 'code' => 'JP', 'phone_code' => '+81'],
        ];

        DB::table('countries')->insert($countries);
    }
}
