<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestionChoice extends Model
{
    use HasFactory;

    protected $table = 'quiz_question_choices';

    protected $fillable = ['question_id', 'choice_text', 'is_correct'];
}
