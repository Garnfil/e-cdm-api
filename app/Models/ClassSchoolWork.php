<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchoolWork extends Model
{
    use HasFactory;

    protected $table = "class_school_works";

    protected $fillable = ['class_id', 'school_work_id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }
}
