<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoodboardPhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('moodboard_photos')->insert([
            'image_path' => 'sample_moodboard_photo_path.jpg',
            'moodboard_id' => 1, // Replace with the actual moodboard_id
        ]);
    }
}
