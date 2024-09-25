<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'title' => 'Introduction to Computing',
                'code' => 'IT101',
                'description' => 'Fundamental concepts in computing and computer science.',
                'course_id' => 1, // BSIT
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Computer Programming 1',
                'code' => 'IT102',
                'description' => 'Basic programming concepts using high-level programming languages.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Discrete Mathematics',
                'code' => 'IT103',
                'description' => 'Mathematical structures and concepts relevant to computing.',
                'course_id' => 1,
                'type' => 'minor',
                'status' => 'active',
            ],
            [
                'title' => 'Data Structures and Algorithms',
                'code' => 'IT201',
                'description' => 'Introduction to data structures and algorithm design.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Database Management Systems',
                'code' => 'IT202',
                'description' => 'Database design, SQL, and database management.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Web Systems and Technologies',
                'code' => 'IT203',
                'description' => 'Introduction to web technologies and web development.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Networking Fundamentals',
                'code' => 'IT204',
                'description' => 'Basic principles of computer networks and communication protocols.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Information Assurance and Security',
                'code' => 'IT205',
                'description' => 'Basic concepts of cybersecurity and information security.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Human-Computer Interaction',
                'code' => 'IT206',
                'description' => 'Design and evaluation of user interfaces.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'IT Elective 1',
                'code' => 'IT207',
                'description' => 'An elective subject relevant to information technology.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ],
            [
                'title' => 'Capstone Project 1',
                'code' => 'IT301',
                'description' => 'The first phase of the capstone project for BSIT students.',
                'course_id' => 1,
                'type' => 'major',
                'status' => 'active',
            ]
        ]);
    }
}
