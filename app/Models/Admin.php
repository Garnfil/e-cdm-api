<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'email',
        'password',
        'firstname',
        'lastname',
        'contact_no',
        'address',
        'gender',
        'status',
        'admin_role',
    ];
}
