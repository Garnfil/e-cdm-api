<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRubric extends Model
{
    use HasFactory;

    protected $table = 'rubrics';

    protected $fillable = [
        'class_id',
        'assessment_type',
        'assignment_percentage',
        'quiz_percentage',
        'exam_percentage',
        'activity_percentage',
        'attendance_percentage',
        'other_performance_percentage',
    ];
}
