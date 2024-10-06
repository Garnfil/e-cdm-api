<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    use HasFactory;

    protected $table = 'student_activities';

    protected $fillable = ['activity_id', 'student_id', 'score', 'grade', 'datetime_submitted'];

    public function student()
    {
        $this->belongsTo(Student::class, 'student_id');
    }

    public function activity()
    {
        $this->belongsTo(Activity::class, 'activity_id');
    }
}
