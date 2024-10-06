<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolWork extends Model
{
    use HasFactory;

    protected $table = 'school_works';

    protected $fillable = ['class_id', 'instructor_id', 'title', 'description', 'file_paths', 'type', 'status'];

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
}
