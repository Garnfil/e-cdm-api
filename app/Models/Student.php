<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Student extends Model
{
    use HasApiTokens, HasFactory;
    protected $table = "students";
    protected $fillable = [
        'student_id', 
        'email', 
        'password', 
        'firstname', 
        'lastname',
        'middlename',
        'year_level',
        'section',
        'age',
        'birthdate',
        'gender',
        'current_address',
        'avatar_path',
        'status',
    ];

    protected $hidden = ['password'];
}
