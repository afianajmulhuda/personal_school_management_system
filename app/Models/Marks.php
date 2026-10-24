<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Marks extends Model
{
    protected $fillable = ['exam_id', 'student_enrollment_id', 'marks_obtained', 'is_absent', 'teacher_remarks'];
    protected $casts = ['is_absent' => 'boolean'];

    public function exam(): BelongsTo {
        return $this->belongsTo(Exams::class,'exam_id');
    }

    public function studentEnrollment(): BelongsTo
    {
        return $this->belongsTo(Student_Enrollments::class, 'student_enrollment_id');
    }
}