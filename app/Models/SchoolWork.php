<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolWork extends Model
{
    use HasFactory;
    protected $table = "school_works";
    protected $fillable = ["class_id", "instructor_id", "title", "description", "file_paths", "type", "status"];
}
