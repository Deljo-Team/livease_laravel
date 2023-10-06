<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'sub_category_id' => 1,
                'type' => 'select',
                'question' => 'Select your preference',
                'answer' => json_encode(['option 1', 'option 2', 'option 3']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sub_category_id' => 1,
                'type' => 'text',
                'question' => 'Enter your name',
                'answer' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sub_category_id' => 1,
                'type' => 'date',
                'question' => 'Select a date',
                'answer' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sub_category_id' => 1,
                'type' => 'time',
                'question' => 'Select a time',
                'answer' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sub_category_id' => 1,
                'type' => 'file',
                'question' => 'Upload a file',
                'answer' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sub_category_id' => 1,
                'type' => 'boolean',
                'question' => 'Is this true?',
                'answer' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sub_category_id' => 2,
                'type' => 'select',
                'question' => 'Select your preference',
                'answer' => json_encode(['option 1', 'option 2', 'option 3']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sub_category_id' => 2,
                'type' => 'boolean',
                'question' => 'Is this true?',
                'answer' => null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

           DB::table('sub_category_questions')->insert($questions);
    }
}
