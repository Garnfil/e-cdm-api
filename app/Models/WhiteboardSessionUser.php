<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhiteboardSessionUser extends Model
{
    use HasFactory;
    protected $table = "whiteboard_session_users";

    protected $fillable = [
        'whiteboard_id',
        'user_id',
        'room_token',
        'user_type',
        'user_role',
    ];
}
