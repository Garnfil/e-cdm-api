<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubmissionAttachment extends Model
{
    use HasFactory;
    protected $table = "student_submission_attachments";
    protected $fillable = ['student_submission_id', 'student_id', 'attachment_name', 'attachment_type', 'status'];

    const ATTACHMENT_TYPE_FILE = 'file';
    const ATTACHMENT_TYPE_LINK = 'link';
}
