<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = ['institute_id', 'name', 'logo_file_name'];

    public function institute()
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }
}
