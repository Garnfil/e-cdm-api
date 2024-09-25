<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('institutes')->insert([
            'name' => 'Institute Of Computer Studies',
            'description' => "This institute focus on IT"
        ]);

        DB::table('institutes')->insert([
            'name' => 'Institute Of Education',
            'description' => "This institute focus on Education"
        ]);

        DB::table('institutes')->insert([
            'name' => 'Institute of Business and Entrepreneurship',
            'description' => "This institute focus on Education"
        ]);
    }
}
