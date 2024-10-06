<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignment extends Model
{
    use HasFactory;

    protected $table = 'student_assignments';

    protected $fillable = ['assignment_id', 'student_id', 'score', 'grade', 'datetime_submitted'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function attachments()
    {
        return $this->hasMany(StudentAssignmentAttachment::class, 'student_assignment_id');
    }
}
