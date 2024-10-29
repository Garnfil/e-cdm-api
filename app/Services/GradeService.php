<?php

namespace App\Services;

use App\Models\Activity;
use App\Models\Assignment;
use App\Models\ClassRubric;
use App\Models\Exam;
use App\Models\StudentSchoolWorkGrade;
use App\Models\StudentSubmission;

class GradeService
{
    public function computeClassStudentGrade($type, $student_id, $class_id)
    {
        $rubric = ClassRubric::where('class_id', $class_id)->first();

        $types = [
            'assignment' => 'assignment_percentage',
            'activity' => 'activity_percentage',
            'quiz' => 'quiz_percentage',
            'exam' => 'exam_percentage',
        ];

        if (isset($types[$type])) {
            return $this->computeGrade($type, $student_id, $class_id, $rubric, $types[$type]);
        }

        return null;
    }

    private function computeGrade($type, $student_id, $class_id, $rubric, $percentageField)
    {
        // Define school work model based on type
        $models = [
            'assignment' => Assignment::class,
            'activity' => Activity::class,
            'quiz' => Activity::class, // Assuming quiz is stored in Activity model
            'exam' => Exam::class,
        ];

        $submissionType = [
            'assignment' => StudentSubmission::ASSIGNMENT_TYPE,
            'activity' => StudentSubmission::ACTIVITY_TYPE,
            'quiz' => StudentSubmission::QUIZ_TYPE,
            'exam' => StudentSubmission::EXAM_TYPE,
        ];

        $model = $models[$type];
        $schoolWorkType = $submissionType[$type];

        // Get total points directly from the database
        $totalPoints = $model::whereHas('school_work', function ($q) use ($class_id) {
            $q->where('class_id', $class_id);
        })->sum('points');

        // Get student score directly from the database
        $totalScore = StudentSubmission::where('school_work_type', $schoolWorkType)
            ->where('student_id', $student_id)
            ->sum('score');

        $percentageScore = $totalPoints > 0 ? ($totalScore / $totalPoints) * 100 : 0;

        // Calculate the weighted grade based on the rubric percentage
        $percentage = $rubric->$percentageField / 100;
        $weightedGrade = $percentageScore * $percentage;

        switch ($type) {
            case 'assignment':
                $percentage_label = 'assignment_grade_percentage';
                break;

            case 'activity':
                $percentage_label = 'activities_grade_percentage';
                break;

            case 'quiz':
                $percentage_label = 'quizzes_grade_percentage';
                break;

            case 'exam':
                $percentage_label = 'exams_grade_percentage';
                break;

            default:
                $percentage_label = 'other_performances_grade_percentage';
                break;
        }

        // Update or create the student grade
        StudentSchoolWorkGrade::updateOrCreate([
            'class_id' => $class_id,
            'student_id' => $student_id,
            'assessment_category' => $rubric->assessment_type,
        ], [
            $percentage_label => $weightedGrade,
        ]);

        return $weightedGrade;
    }
}
