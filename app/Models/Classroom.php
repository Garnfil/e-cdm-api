<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = ['title', 'description', 'current_assessment_category', 'class_code', 'subject_id', 'section_id', 'instructor_id', 'cover_image_file_name', 'status'];
}
