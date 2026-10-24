<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam_Terms extends Model
{
    protected $table = 'exam_terms';
    protected $fillable = [
        'academic_year_id',
        'name',
        'weightage',
    ];

    protected $casts = [
        'weightage' => 'integer',
    ];

    /**
     * Get the academic year this term belongs to.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYears::class);
    }

    /**
     * Get the exams associated with this exam term block.
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exams::class);
    }
    public function invoices(): HasMany
    {
        return $this->hasMany(ExamInvoice::class);
    }
}