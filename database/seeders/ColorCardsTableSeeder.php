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
    public function run(): void
    {
        DB::table('color_cards')->insert([
            'hexcode' => '#FF5733',
            'moodboard_id' => 1, // Replace with the actual moodboard_id
        ]);
    }
}
