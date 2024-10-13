<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';

    protected $fillable = [
        'school_work_id',
        'notes',
        'points',
        'assessment_type',
        'quiz_type',
        'has_quiz_form',
        'due_datetime',
    ];

    protected $casts = [
        'has_quiz_form' => 'boolean',
    ];

    public function school_work()
    {
        return $this->belongsTo(SchoolWork::class, 'school_work_id');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }
}
