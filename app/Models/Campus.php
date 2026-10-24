<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campus extends Model
{
    protected $fillable = ['name', 'code', 'location'];

    public function sections(): HasMany {
        return $this->hasMany(Sections::class);
    }

    public function enrollments(): HasMany {
        return $this->hasMany(Student_Enrollments::class);
    }
}