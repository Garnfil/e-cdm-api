<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';

    protected $fillable = ['class_id', 'sender_id', 'sender_type', 'content'];

    public function sender()
    {
        return $this->morphTo();
    }
}
