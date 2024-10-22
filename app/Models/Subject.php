<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';

    protected $fillable = ['title', 'code', 'description', 'course_id', 'type', 'status'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
