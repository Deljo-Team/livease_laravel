<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $categories = [
           [
               'name' => 'Electronics',
               'slug' => 'electronics',
               'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
               'status' => 1,
           ],
           [
               'name' => 'Fashion',
               'slug' => 'fashion',
               'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
               'status' => 1,
           ],
           [
               'name' => 'Home & Kitchen',
               'slug' => 'home-kitchen',
               'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
               'status' => 1,
           ],
           [
               'name' => 'Beauty & Health',
               'slug' => 'beauty-health',
               'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
               'status' => 1,
           ]];

           DB::table('categories')->insert($categories);
    }
}
