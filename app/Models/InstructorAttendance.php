<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorAttendance extends Model
{
    use HasFactory;

    protected $table = 'instructor_attendances';
    protected $fillable = [
        'instructor_id',
        'class_id',
        'room',
        'attendance_datetime',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean'
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
