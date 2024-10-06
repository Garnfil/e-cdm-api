<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentActivityAttachment extends Model
{
    use HasFactory;

    protected $table = 'student_activity_attachments';

    protected $fillable = ['student_activity_id', 'attachment_name', 'attachment_type', 'status'];
}
