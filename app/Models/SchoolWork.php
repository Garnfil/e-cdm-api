<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolWork extends Model
{
    use HasFactory;

    protected $table = 'school_works';

    protected $fillable = ['class_id', 'instructor_id', 'title', 'description', 'file_paths', 'type', 'status', 'due_datetime'];

    public function class_school_work()
    {
        return $this->belongsTo(ClassSchoolWork::class, 'class_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function attachments()
    {
        return $this->hasMany(SchoolWorkAttachment::class, 'school_work_id');
    }

    public function assignment()
    {
        return $this->hasOne(Assignment::class, 'school_work_id');
    }

    public function activity()
    {
        return $this->hasOne(Activity::class, 'school_work_id');
    }

    public function quiz()
    {
        return $this->hasOne(Quiz::class, 'school_work_id');
    }

    public function exam()
    {
        return $this->hasOne(Exam::class, 'school_work_id');
    }

    public function student_submissions()
    {
        return $this->hasMany(StudentSubmission::class, 'school_work_id');
    }

    public function schoolWorkPoints()
    {
        $points = 0;
        switch ($this->type)
        {
            case 'assignment':
                $points = $this->assignment->points;
                break;

            case 'activity':
                $points = $this->activity->points;
                break;

            case 'quiz':
                $points = $this->quiz->points;
                break;

            case 'exam':
                $points = $this->exam->points;
                break;
        }

        return $points;
    }
}
