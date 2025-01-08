<?php

namespace Database\Seeders;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::create([
            'student_id' => '21-00091',
            'email' => 'jamesgarnfil15@gmail.com',
            'password' => Hash::make('Test123!'),
            'firstname' => 'James Benedict',
            'lastname' => 'Garnfil',
            'year_level' => 4,
            'section' => '4H',
            'age' => 21,
            'birthdate' => '2003-10-15',
            'course_id' => 1,
            'institute_id' => 1,
            'role' => 'student',
            'status' => 'active',
            'email_verified_at' => Carbon::now(),
        ]);
    }
}
