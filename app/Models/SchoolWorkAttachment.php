<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolWorkAttachment extends Model
{
    use HasFactory;

    protected $table = 'school_work_attachments';

    protected $fillable = ['school_work_id', 'attachment_name', 'school_work_type', 'attachment_type', 'status'];

    const ATTACHMENT_TYPE_FILE = 'file';

    const ATTACHMENT_TYPE_LINK = 'link';
}
