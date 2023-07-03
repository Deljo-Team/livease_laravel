<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'title' => 'Mr',
                'name' => 'John Doe',
                'email' => 'johndoe@example.com',
                'country_code' => 'US',
                'phone' => '1234567890',
                'password' => Hash::make('password'),
                'latitude' => 37.7749,
                'longitude' => -122.4194,
                'type'=> 'admin',
                'avatar' => null,
            ],
            [
                'title' => 'Mrs',
                'name' => 'Jane Smith',
                'email' => 'janesmith@example.com',
                'country_code' => 'GB',
                'phone' => '9876543210',
                'password' => Hash::make('password'),
                'latitude' => 51.5074,
                'longitude' => -0.1278,
                'type'=> 'admin',
                'avatar' => null,
            ],
            [
                'title' => 'Mr',
                'name' => 'Robert Johnson',
                'email' => 'robertjohnson@example.com',
                'country_code' => 'CA',
                'phone' => '5555555555',
                'password' => Hash::make('password'),
                'latitude' => 45.4215,
                'longitude' => -75.6999,
                'type'=> 'admin',
                'avatar' => null,
            ],
            [
                'title' => 'Ms',
                'name' => 'Maria Garcia',
                'email' => 'mariagarcia@example.com',
                'country_code' => 'ES',
                'phone' => '9876543290',
                'password' => Hash::make('password'),
                'latitude' => 40.4168,
                'longitude' => -3.7038,
                'type'=> 'admin',
                'avatar' => null,
            ],
            [
                'title' => 'Dr',
                'name' => 'Mohammed Ahmed',
                'email' => 'mohammedahmed@example.com',
                'country_code' => 'AE',
                'phone' => '12345672340',
                'password' => Hash::make('password'),
                'latitude' => 25.2048,
                'longitude' => 55.2708,
                'type'=> 'admin',
                'avatar' => null,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
