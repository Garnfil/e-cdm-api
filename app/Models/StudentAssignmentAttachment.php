<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignmentAttachment extends Model
{
    use HasFactory;

    protected $table = 'student_assignment_attachments';

    protected $fillable = ['student_assignment_id', 'attachment_name', 'attachment_type', 'status'];
}
