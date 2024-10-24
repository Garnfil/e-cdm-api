<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendances';

    protected $fillable = [
        'class_id',
        'attendance_code',
        'attendance_datetime',
    ];

    public function class()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
