<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubmittedAttachment extends Model
{
    use HasFactory;

    protected $table = 'student_submitted_attachments';

    protected $fillable = [
        'student_submission_id',
        'attachment_name',
        'attachment_type',
        'status',
    ];
}
