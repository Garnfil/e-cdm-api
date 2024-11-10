<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JoinedStudent extends Model
{
    use HasFactory;
    protected $table = "joined_students";
    protected $fillable = [
        "session_id",
        "student_id",
        "joined_start_time",
        "status"
    ];
}
