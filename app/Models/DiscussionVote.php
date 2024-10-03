<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionVote extends Model
{
    use HasFactory;

    protected $table = 'discussion_votes';

    protected $fillable = ['post_id', 'comment_id', 'user_id', 'user_type', 'vote_type'];
}
