<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $table = 'modules';

    protected $fillable = ['class_id', 'instructor_id', 'title', 'description', 'file_paths', 'status', 'scheduled_datetime'];

    public function attachments()
    {
        return $this->hasMany(ModuleAttachment::class, 'module_id');
    }
}
