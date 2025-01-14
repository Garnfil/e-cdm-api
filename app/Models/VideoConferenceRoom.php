<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoConferenceRoom extends Model
{
    use HasFactory;
    protected $table = "live_sessions";
    protected $fillable = [
        "title",
        "description",
        "instructor_id",
        "session_code",
        "scheduled_datetime",
        "class_id",
        "grace_period",
        "start_datetime",
        "end_datetime",
        "status"
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class, 'instructor_id');
    }

    public function joined_students()
    {
        return $this->hasMany(JoinedStudent::class, 'session_id');
    }
}
