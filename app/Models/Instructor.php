<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory;
    protected $table = "instructors";
    protected $fillable = [
        "email",
        "username",
        "firstname",
        "lastname",
        "middlename",
        "age",
        "institute_id",
        "course_id",
        "is_verified"
    ];

    protected $casts = [
        "is_verified" => boolean,
    ];

    public function institute() {
        return $this->belongsTo(Institute::class, 'institute_id');
    }

    public function course() {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
