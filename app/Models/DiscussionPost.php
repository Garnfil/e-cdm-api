<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscussionPost extends Model
{
    use HasFactory;

    protected $table = 'discussion_posts';

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'user_type',
        'images',
        'visibility',
        'institute_id',
        'course_id',
        'section_id',
    ];

    public function comments()
    {
        return $this->hasMany(DiscussionComment::class, 'post_id')->latest();
    }

    public function votes()
    {
        return $this->hasMany(DiscussionVote::class, 'post_id');
    }

    // User Relationship: Student or Instructor
    public function user()
    {
        // Ensure case-sensitivity
        if ($this->user_type === 'App\Models\Student') {
            return $this->student(); // Correct lowercase call
        } else {
            return $this->instructor();
        }
    }

    public function student()
    {
        // Use correct casing for model
        return Student::find($this->user_id);
    }

    public function instructor()
    {
        // Use correct casing for model
        return Instructor::find($this->user_id);
    }

    public function upvotesCount()
    {
        return $this->votes()->where('vote_type', 'upvote')->count();
    }

    public function downvotesCount()
    {
        return $this->votes()->where('vote_type', 'downvote')->count();
    }

    public function voteScore()
    {
        return $this->votes()->where('vote_type', 'upvote')->count() -
               $this->votes()->where('vote_type', 'downvote')->count();
    }
}
