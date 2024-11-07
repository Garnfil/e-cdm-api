<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    use HasFactory;
    protected $table = "school_events";
    protected $fillable = [
        "name",
        "event_date",
        "description"
    ];

    protected $dates = ['event_date'];
}
