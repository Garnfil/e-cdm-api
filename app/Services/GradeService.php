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

        switch ($type) {
            case 'assignment':
                $this->computeAssignmentsGrade($student_id, $class_id, $rubric);
                break;

            case 'activity':
                $this->computeActivitiesGrade($student_id, $class_id, $rubric);
                break;

            case 'quiz':
                $this->computeActivitiesGrade($student_id, $class_id, $rubric);
                break;

            case 'exam':
                $this->computeExamGrade($student_id, $class_id, $rubric);
                break;
        }
    }

    public function computeAssignmentsGrade($student_id, $class_id, $rubric)
    {

        $assignments = Assignment::whereHas('school_work', function ($q) use ($class_id) {
            $q->where('class_id', $class_id);
        })->get();

        $student_submissions = StudentSubmission::where('school_work_type', StudentSubmission::ASSIGNMENT_TYPE)
            ->where('student_id', $student_id)
            ->get();

        $assignmentTotalPoints = $assignments->sum('points');
        $assignmentScore = $student_submissions->sum('score');

        $percentage_score = ($assignmentScore / $assignmentTotalPoints) * 100; // 100%

        $assignment_percentage = $rubric->assignment_percentage / 100;
        $weighted_assignment_grade = $percentage_score * $assignment_percentage;

        StudentSchoolWorkGrade::updateOrCreate([
            'class_id' => $class_id,
            'student_id' => $student_id,
            'assessment_category' => $rubric->assessment_type,
        ], [
            'assignment_grade_percentage' => $weighted_assignment_grade,
        ]);

        return $weighted_assignment_grade;

    }

    public function computeActivitiesGrade($student_id, $class_id, $rubric)
    {

        $activities = Activity::whereHas('school_work', function ($q) use ($class_id) {
            $q->where('class_id', $class_id);
        })->get();

        $student_submissions = StudentSubmission::where('school_work_type', StudentSubmission::ACTIVITY_TYPE)
            ->where('student_id', $student_id)
            ->get();

        $activityTotalPoints = $activities->sum('points');
        $activityScore = $student_submissions->sum('score');

        $percentage_score = ($activityScore / $activityTotalPoints) * 100;
        $activity_percentage = $rubric->activity_percentage / 100;
        $weighted_activity_grade = $percentage_score * $activity_percentage;

        StudentSchoolWorkGrade::updateOrCreate([
            'class_id' => $class_id,
            'student_id' => $student_id,
            'assessment_category' => $rubric->assessment_type,
        ], [
            'activities_grade_percentage' => $weighted_activity_grade,
        ]);

        return $weighted_activity_grade;

    }

    public function computeQuizGrade($student_id, $class_id, $rubric)
    {

        $quizzes = Activity::whereHas('school_work', function ($q) use ($class_id) {
            $q->where('class_id', $class_id);
        })->get();

        $student_submissions = StudentSubmission::where('school_work_type', StudentSubmission::ACTIVITY_TYPE)
            ->where('student_id', $student_id)
            ->get();

        $quizTotalPoints = $quizzes->sum('points');
        $quizScore = $student_submissions->sum('score');

        $percentage_score = ($quizScore / $quizTotalPoints) * 100;
        $quiz_percentage = $rubric->quiz_percentage / 100;
        $weighted_quiz_grade = $percentage_score * $quiz_percentage;

        StudentSchoolWorkGrade::updateOrCreate([
            'class_id' => $class_id,
            'student_id' => $student_id,
            'assessment_category' => $rubric->assessment_type,
        ], [
            'quizzes_grade_percentage' => $weighted_quiz_grade,
        ]);

        return $weighted_quiz_grade;
    }

    public function computeExamGrade($student_id, $class_id, $rubric)
    {

        $exams = Exam::whereHas('school_work', function ($q) use ($class_id) {
            $q->where('class_id', $class_id);
        })->get();

        $student_submissions = StudentSubmission::where('school_work_type', StudentSubmission::EXAM_TYPE)
            ->where('student_id', $student_id)
            ->get();

        $examTotalPoints = $exams->sum('points');
        $examScore = $student_submissions->sum('score');

        $percentage_score = ($examScore / $examTotalPoints) * 100;
        $exam_percentage = $rubric->exam_percentage / 100;
        $weighted_exam_grade = $percentage_score * $exam_percentage;

        StudentSchoolWorkGrade::updateOrCreate([
            'class_id' => $class_id,
            'student_id' => $student_id,
            'assessment_category' => $rubric->assessment_type,
        ], [
            'exams_grade_percentage' => $weighted_exam_grade,
        ]);

        return $weighted_exam_grade;
    }
}
