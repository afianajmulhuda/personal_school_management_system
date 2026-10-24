<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYears extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'is_active', 'is_closed'];
    protected $casts = ['is_active' => 'boolean', 'is_closed' => 'boolean'];

    public function enrollments(): HasMany {
        return $this->hasMany(Student_Enrollments::class);
    }

    public function examTerms(): HasMany {
        return $this->hasMany(Exam_Terms::class);
    }
}