<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            'name' => 'Sample Project 1',
            'description' => 'This is a sample project.',
            'status' => 'Not done',
        ]);

        DB::table('projects')->insert([
            'name' => 'Sample Project 2',
            'description' => 'Another sample project.',
            'status' => 'Done',
        ]);
        DB::table('projects')->insert([
            'name' => 'Sample Project 3',
            'description' => 'Another sample project.',
            'status' => 'Done',
        ]);
    }
}
