<?php

namespace Database\Seeders;

use App\Models\Instructor;
use App\Models\InstructorAttendance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instructor_one = Instructor::create([
            'email' => 'instructor@email.com',
            'username' => 'instructor',
            'password' => Hash::make('Test123!'),
            'firstname' => 'Ins',
            'lastname' => 'Tructor',
            'institute_id' => 1,
            'course_id' => 1,
            'role' => 'instructor',
            'is_verified' => 1,
        ]);

        Instructor::create([
            'email' => 'george@email.com',
            'username' => 'george',
            'password' => Hash::make('Test123!'),
            'firstname' => 'George',
            'lastname' => 'Steve',
            'institute_id' => 1,
            'course_id' => 1,
            'role' => 'instructor',
            'is_verified' => 1,
        ]);
    }
}
