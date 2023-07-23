<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub_categories = [
            [
                'category_id' => 1,
                'name' => 'Mobile',
                'slug' => 'mobile',
                'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
                'status' => 1,
            ],
            [
                'category_id' => 1,
                'name' => 'Laptop',
                'slug' => 'laptop',
                'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
                'status' => 1,
            ],
            [
                'category_id' => 1,
                'name' => 'Tablet',
                'slug' => 'tablet',
                'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
                'status' => 1,
            ],
            [
                'category_id' => 1,
                'name' => 'Camera',
                'slug' => 'camera',
                'image' => 'https://images.unsplash.com/photo-1581090406932-7e0b162c7b6e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8Mnx8ZWxlY3Ryb25pY3N8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80',
                'status' => 1,
            ],
        ];
        DB::table('sub_categories')->insert($sub_categories);
    }
}
