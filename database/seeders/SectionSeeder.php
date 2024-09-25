<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sections')->insert([
            [
                'name' => "1A",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1A',
                'status' => 'active',
            ],
            [
                'name' => "1B",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1B',
                'status' => 'active',
            ],
            [
                'name' => "1C",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1C',
                'status' => 'active',
            ],
            [
                'name' => "1D",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1D',
                'status' => 'active',
            ],
            [
                'name' => "1E",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1E',
                'status' => 'active',
            ],
            [
                'name' => "1F",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1F',
                'status' => 'active',
            ],
            [
                'name' => "1G",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1G',
                'status' => 'active',
            ],
            [
                'name' => "1H",
                'course_id' => 1,
                'year_level' => 1,
                'description' => 'This section is for BSIT 1H',
                'status' => 'active',
            ],
        ]);        
    }
}
