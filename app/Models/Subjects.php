<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $fillable = ['name', 'code', 'is_elective'];
    protected $casts = ['is_elective' => 'boolean'];
}