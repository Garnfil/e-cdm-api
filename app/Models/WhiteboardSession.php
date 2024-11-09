<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteboardSession extends Model
{
    use HasFactory;
    protected $table = "whiteboard_sessions";
    protected $fillable = [
        "session_code",
        "class_id",
        "instructor_id",
        "agora_whiteboard_room_uuid",
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
}
