<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student_Enrollments extends Model
{
    protected $table = 'student_enrollments';
    protected $fillable = [
        'student_id', 'academic_year_id', 'campus_id', 
        'class_id', 'section_id', 'roll_no', 'enrollment_status'
    ];

    public function student(): BelongsTo {
        return $this->belongsTo(Students::class);
    }

    public function academicYear(): BelongsTo {
        return $this->belongsTo(AcademicYears::class,'academic_year_id');
    }

    public function campus(): BelongsTo {
        return $this->belongsTo(Campus::class,'campus_id');
    }

    public function class(): BelongsTo {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section(): BelongsTo {
        return $this->belongsTo(Sections::class, 'section_id');
    }

    public function attendanceRecords(): HasMany {
        return $this->hasMany(Attendance::class, 'student_enrollment_id');
    }

    public function marks(): HasMany {
        return $this->hasMany(Marks::class);
    }
}