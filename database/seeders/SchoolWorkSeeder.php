<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Assignment;
use App\Models\ClassSchoolWork;
use App\Models\Exam;
use App\Models\Quiz;
use App\Models\SchoolWork;
use App\Models\StudentSubmission;
use App\Services\GradeService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SchoolWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [1];

        // For Assignments
        $school_work_assignment = SchoolWork::create([
            'title' => 'Assignment #1',
            'instructor_id' => 1,
            'description' => 'This is description for the assignment #1',
            'type' => 'assignment',
            'status' => 'posted',
            'due_datetime' => Carbon::now()->addDay(),
        ]);

        foreach ($classes as $key => $classroom) {
            ClassSchoolWork::updateOrCreate(
                [
                    'class_id' => $classroom,
                    'school_work_id' => $school_work_assignment->id,
                ],
                [],
            );

            $assignment = Assignment::create([
                'school_work_id' => $school_work_assignment->id,
                'points' => '100',
                'assessment_type' => 'prelim',
            ]);
        }

        $studentAssignmentSubmission = StudentSubmission::updateOrCreate([
            'school_work_id' => $school_work_assignment->id,
            'student_id' => 1,
            'school_work_type' => $school_work_assignment->type,
        ], [
            'score' => 89,
            'grade' => 'passed',
            'datetime_submitted' => Carbon::now(),
        ]);

        // For Activity
        $school_work_activity = SchoolWork::create([
            'title' => 'Activity #1',
            'instructor_id' => 1,
            'description' => 'This is description for the activity #1',
            'type' => 'activity',
            'status' => 'posted',
            'due_datetime' => Carbon::now()->addDay(),
        ]);

        foreach ($classes as $key => $classroom) {
            ClassSchoolWork::updateOrCreate(
                [
                    'class_id' => $classroom,
                    'school_work_id' => $school_work_activity->id,
                ],
                [],
            );

            $activity = Activity::create([
                'school_work_id' => $school_work_activity->id,
                'points' => '100',
                'activity_type' => 'oral',
                'assessment_type' => 'prelim',
            ]);
        }

        $studentActivitySubmission = StudentSubmission::updateOrCreate([
            'school_work_id' => $school_work_activity->id,
            'student_id' => 1,
            'school_work_type' => $school_work_activity->type,
        ], [
            'score' => 92,
            'grade' => 'passed',
            'datetime_submitted' => Carbon::now(),
        ]);

        // For quiz
        $school_work_quiz = SchoolWork::create([
            'title' => 'Quiz #1',
            'instructor_id' => 1,
            'description' => 'This is description for the quiz #1',
            'type' => 'quiz',
            'status' => 'posted',
            'due_datetime' => Carbon::now()->addDay(),
        ]);

        foreach ($classes as $key => $classroom) {
            ClassSchoolWork::updateOrCreate(
                [
                    'class_id' => $classroom,
                    'school_work_id' => $school_work_quiz->id,
                ],
                [],
            );

            $quiz = Quiz::create([
                'school_work_id' => $school_work_quiz->id,
                'points' => 20,
                'quiz_type' => 'short',
                'assessment_type' => 'prelim',
            ]);
        }

        $studentQuizSubmission = StudentSubmission::updateOrCreate([
            'school_work_id' => $school_work_quiz->id,
            'student_id' => 1,
            'school_work_type' => $school_work_quiz->type,
        ], [
            'score' => 17,
            'grade' => 'passed',
            'datetime_submitted' => Carbon::now(),
        ]);

        // For exam
        $school_work_exam = SchoolWork::create([
            'title' => 'exam #1',
            'instructor_id' => 1,
            'description' => 'This is description for the exam #1',
            'type' => 'exam',
            'status' => 'posted',
            'due_datetime' => Carbon::now()->addDay(),
        ]);

        foreach ($classes as $key => $classroom) {
            ClassSchoolWork::updateOrCreate(
                [
                    'class_id' => $classroom,
                    'school_work_id' => $school_work_exam->id,
                ],
                [],
            );

            $exam = Exam::create([
                'school_work_id' => $school_work_exam->id,
                'points' => '60',
                'exam_type' => 'prelim exam',
                'assessment_type' => 'prelim',
            ]);
        }

        $studentExamSubmission = StudentSubmission::updateOrCreate([
            'school_work_id' => $school_work_exam->id,
            'student_id' => 1,
            'school_work_type' => $school_work_exam->type,
        ], [
            'score' => '48',
            'grade' => 'passed',
            'datetime_submitted' => Carbon::now(),
        ]);

        $gradeService = new GradeService();
        $gradeService->computeClassStudentGrade('assignment', 1, 1);
        $gradeService->computeClassStudentGrade('activity', 1, 1);
        $gradeService->computeClassStudentGrade('quiz', 1, 1);
        $gradeService->computeClassStudentGrade('exam', 1, 1);


    }
}
