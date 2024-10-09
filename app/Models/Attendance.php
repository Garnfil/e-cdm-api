<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = "";
    protected $fillable = [
        "class_id",
        "attendance_code",
        "student_id",
    ];
}
