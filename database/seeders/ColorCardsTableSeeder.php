<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorCardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $hexcodes = ['#FF5733', '#3366FF', '#66FF33', '#FF33CC', '#FFFF33']; // Add more hexcodes as needed

        foreach ($hexcodes as $hexcode) {
            DB::table('color_cards')->insert([
                'hexcode' => $hexcode,
                'moodboard_id' => 1, // Replace with the actual moodboard_id
            ]);
        }
    }
}
