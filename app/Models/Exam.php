<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $table = "exams";
    protected $fillable = [
        "school_work_id",
        "notes",
        "points",
        "assessment_type",
        "exam_type",
        "due_datetime"
    ];

    public function school_work()
    {
        return $this->belongsTo(SchoolWork::class, 'school_work_id');
    }
}
