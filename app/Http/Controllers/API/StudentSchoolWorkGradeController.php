<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ClassRubric;
use App\Models\StudentSchoolWorkGrade;
use App\Models\StudentSubmission;

class StudentSchoolWorkGradeController extends Controller
{
    public function getStudentSchoolWorkGrades($studentId, $classId)
    {
        // Get the grades for each school work type for the specified student and class
        $grades = StudentSchoolWorkGrade::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->select(
                'assignment_grade_percentage as assignment_grade',
                'activities_grade_percentage as activities_grade',
                'quizzes_grade_percentage as quizzes_grade',
                'exams_grade_percentage as exams_grade',
                'atttendance_grade_percentage as attendance_grade',
                'other_performances_grade_percentage as other_performances_grade'
            )
            ->first();

        // Count the total submitted works for each school work type
        $submittedCounts = StudentSubmission::where('student_id', $studentId)
            ->whereHas('school_work', function ($query) use ($classId) {
                $query->where('class_id', $classId);
            })
            ->selectRaw('school_work_type, COUNT(*) as total_submitted')
            ->groupBy('school_work_type')
            ->pluck('total_submitted', 'school_work_type');

        $rubrics = ClassRubric::select('assignment_percentage', 'quiz_percentage', 'exam_percentage', 'activity_percentage', 'attendance_percentage', 'other_performance_percentage')
            ->where('class_id', $classId)->first();

        return response()->json([
            'grades' => [
                'assignment' => $grades->assignment_grade ?? 0,
                'activities' => $grades->activities_grade ?? 0,
                'quizzes' => $grades->quizzes_grade ?? 0,
                'exams' => $grades->exams_grade ?? 0,
                'attendance' => $grades->attendance_grade ?? 0,
                'other_performances' => $grades->other_performances_grade ?? 0,
            ],
            'submitted_counts' => [
                'assignment' => $submittedCounts['assignment'] ?? 0,
                'activity' => $submittedCounts['activity'] ?? 0,
                'quiz' => $submittedCounts['quiz'] ?? 0,
                'exam' => $submittedCounts['exam'] ?? 0,
            ],
            'rubrics' => $rubrics,
        ]);
    }
}
