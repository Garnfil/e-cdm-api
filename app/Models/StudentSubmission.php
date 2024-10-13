<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubmission extends Model
{
    use HasFactory;

    protected $table = 'student_submissions';

    protected $fillable = [
        'school_work_id',
        'student_id',
        'score',
        'grade',
        'school_work_type',
        'datetime_submitted',
    ];

    public function school_work()
    {
        return $this->belongsTo(SchoolWork::class, 'school_work_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function attachments()
    {
        return $this->hasMany(StudentSubmissionAttachment::class, 'student_submission_id');
    }
}
