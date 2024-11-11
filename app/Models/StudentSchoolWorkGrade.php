<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSchoolWorkGrade extends Model
{
    use HasFactory;

    protected $table = 'student_school_works_grades';

    protected $fillable = [
        'class_id',
        'student_id',
        'graded_by',
        'assessment_category',
        'assignment_grade_percentage',
        'activities_grade_percentage',
        'quizzes_grade_percentage',
        'exams_grade_percentage',
        'atttendance_grade_percentage',
        'other_performances_grade_percentage',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
