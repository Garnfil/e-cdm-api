<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;
    protected $table = "class_schedules";

    protected $fillable = ["instructor_id", "class_id", "schedule_date", "day_of_week", "start_time", "end_time"];
}
