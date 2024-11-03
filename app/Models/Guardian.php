<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Guardian extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'guardians';

    protected $fillable = [
        'email',
        'password',
        'firstname',
        'lastname',
        'middlename',
        'phone_number',
        'gender',
        'birthdate',
        'age',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(StudentGuardian::class, 'guardian_id');
    }
}
