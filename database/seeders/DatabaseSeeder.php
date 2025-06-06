<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            InstituteSeeder::class,
            CourseSeeder::class,
            SectionSeeder::class,
            SubjectSeeder::class,
            InstructorSeeder::class,
            StudentSeeder::class,
            AdminSeeder::class,
            DiscussionSeeder::class,
            ClassroomSeeder::class,
            ClassRubricSeeder::class,
            SchoolWorkSeeder::class,
        ]);
    }
}
