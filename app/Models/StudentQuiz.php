<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuiz extends Model
{
    use HasFactory;

    protected $table = 'student_quizzes';

    protected $fillable = ['quiz_id', 'student_id', 'score', 'grade', 'datetime_submitted'];
}
