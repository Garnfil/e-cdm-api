<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizStudentAnswer extends Model
{
    use HasFactory;

    protected $table = 'quiz_student_answers';

    protected $fillable = [
        'quiz_id',
        'student_id',
        'question_id',
        'answer_text',
        'is_correct',
    ];
}
