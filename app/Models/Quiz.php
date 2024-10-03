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
        'due_datetime',
    ];

    public function school_work()
    {
        return $this->belongsTo(SchoolWork::class, 'school_work_id');
    }
}
