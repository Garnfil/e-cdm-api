<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGuardian extends Model
{
    use HasFactory;

    protected $table = 'students_guardians';

    protected $fillable = [
        'student_id',
        'guardian_id',
    ];
}
