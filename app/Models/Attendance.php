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
        'grace_period_minute',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }


}
