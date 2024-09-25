<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            'institute_id' => 1,
            'name' => 'Bachelor of Science in Information Technology',
        ]);

        DB::table('courses')->insert([
            'institute_id' => 1,
            'name' => 'Bachelor of Science in Computer Engineering',
        ]);
    }
}
