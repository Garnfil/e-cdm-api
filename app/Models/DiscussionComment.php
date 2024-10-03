<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionComment extends Model
{
    use HasFactory;

    protected $table = 'discussion_comments';

    protected $fillable = ['post_id', 'user_id', 'user_type', 'comment'];
}
