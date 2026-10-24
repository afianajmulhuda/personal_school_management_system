<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamInvoice extends Model
{
    protected $fillable = [
        'student_enrollment_id',
        'exam_term_id',
        'amount_due',
        'amount_paid',
        'status',
        'due_date',
        'payment_date'
    ];

    protected $casts = [
        'amount_due' => 'decimal:2',
        'amount_paid' => 'decimal:2',
        'due_date' => 'date',
        'payment_date' => 'date',
    ];

    // Read remaining balanced value on individual statements dynamically
    public function getBalanceAttribute(): float
    {
        return max(0.00, $this->amount_due - $this->amount_paid);
    }

    public function studentEnrollment(): BelongsTo
    {
        return $this->belongsTo(Student_Enrollments::class);
    }

    public function examTerm(): BelongsTo
    {
        return $this->belongsTo(Exam_Terms::class);
    }
}