<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFinalGrade extends Model
{
    use HasFactory;

    protected $table = 'student_final_grades';

    protected $fillable = [
        'student_school_works_grade_id',
        'student_id',
        'class_id',
        'assessment_type',
        'final_grade',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
