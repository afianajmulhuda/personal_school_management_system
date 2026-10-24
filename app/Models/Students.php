<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Students extends Model
{
    protected $fillable = [
        'admission_no', 'campus_id', 'guardian_id', 'first_name', 'middle_name',
        'last_name', 'date_of_birth', 'gender', 'blood_group', 'nationality',
        'religion', 'student_phone', 'student_email', 'current_address',
        'permanent_address', 'registration_date', 'status', 'photo_url'
    ];

    public function guardian(): BelongsTo {
        return $this->belongsTo(Guardians::class,'guardian_id');
    }
    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class, 'campus_id');
    }

    public function enrollments(): HasMany {
        return $this->hasMany(Student_Enrollments::class);
    }

    // Sugar relationship to instantly get current year tracking parameters
    public function currentEnrollment(): HasOne {
        return $this->hasOne(Student_Enrollments::class)
            ->whereHas('academicYear', function ($query) {
                $query->where('is_active', true);
            });
    }
}
