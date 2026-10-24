<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $fillable = ['student_enrollment_id', 'attendance_date', 'status', 'remarks', 'marked_by_user_id'];

    public function enrollment(): BelongsTo {
        return $this->belongsTo(Student_Enrollments::class, 'student_enrollment_id');
    }
}