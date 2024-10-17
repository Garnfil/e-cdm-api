<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $table = 'sections';

    protected $fillable = ['name', 'course_id', 'year_level', 'description', 'status'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
