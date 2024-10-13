<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $table = 'assignments';

    protected $fillable = ['school_work_id', 'notes', 'points', 'assessment_type'];

    public function school_work()
    {
        return $this->belongsTo(SchoolWork::class, 'school_work_id');
    }
}
