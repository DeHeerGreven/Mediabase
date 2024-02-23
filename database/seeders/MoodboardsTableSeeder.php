<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoodboardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('moodboards')->insert([
            'name' => 'Sample Moodboard',
            'description' => 'This is a sample moodboard.',
            'project_id' => 3, // Replace with the actual project_id
        ]);
    }
}
