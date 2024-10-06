<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuizAttachment extends Model
{
    use HasFactory;

    protected $table = 'student_quiz_attachments';

    protected $fillable = ['student_quiz_id', 'attachment_name', 'attachment_type', 'status'];
}
