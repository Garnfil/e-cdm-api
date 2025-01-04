<?php

namespace Database\Seeders;

use App\Models\Classroom;
use App\Models\InstructorAttendance;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classCode = Str::random(12);


        $class_one = Classroom::create([
            'title' => 'Test',
            'class_code' => $classCode,
            'semester' => '1st',
            'subject_id' => 11,
            'section_id' => 9,
            'instructor_id' => 1,
            'current_assessment_category' => 'prelim',
            'status' => 'active',
        ]);

        InstructorAttendance::create([
            'instructor_id' => 1,
            'class_id' => $class_one->id,
            'room' => 'O-114',
            'attendance_date' => Carbon::now(),
        ]);

        $classCodeOne = Str::random(12);

        $class_two = Classroom::create([
            'title' => 'Test 2',
            'class_code' => $classCodeOne,
            'semester' => '1st',
            'subject_id' => 8,
            'section_id' => 9,
            'instructor_id' => 2,
            'current_assessment_category' => 'prelim',
            'status' => 'active',
        ]);

        InstructorAttendance::create([
            'instructor_id' => 2,
            'class_id' => $class_two->id,
            'room' => 'N-124',
            'attendance_date' => Carbon::now(),
        ]);
    }
}
