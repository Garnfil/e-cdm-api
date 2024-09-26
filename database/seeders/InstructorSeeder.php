<?php

namespace Database\Seeders;

use App\Models\Instructor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InstructorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Instructor::create([
            'email' => 'instructor@email.com',
            'username' => 'instructor',
            'password' => Hash::make('Test123!'),
            'firstname' => 'Ins',
            'lastname' => 'Tructor',
            'institute_id' => 1,
            'course_id' => 1,
            'is_verified' => 1,
        ]);
    }
}
