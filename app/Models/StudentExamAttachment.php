<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamAttachment extends Model
{
    use HasFactory;

    protected $table = 'student_exam_attachments';

    protected $fillable = ['student_exam_id', 'attachment_name', 'attachment_type', 'status'];
}
