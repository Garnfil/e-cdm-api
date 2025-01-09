<?php

namespace Database\Seeders;

use App\Models\ClassRubric;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassRubricSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClassRubric::create([
            'class_id' => 1,
            'assessment_type' => 'prelim',
            'assignment_percentage' => '15',
            'quiz_percentage' => '25',
            'activity_percentage' => '20',
            'exam_percentage' => '30',
            'attendance_percentage' => '5',
            'other_performance_percentage' => '5',
        ]);
    }
}
