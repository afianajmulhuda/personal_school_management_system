<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exams extends Model
{
    protected $fillable = [
        'exam_term_id',
        'section_id',
        'subject_id',
        'exam_date',
        'max_marks',
        'min_passing_marks',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'max_marks' => 'decimal:2',
        'min_passing_marks' => 'decimal:2',
    ];

    public function examTerm(): BelongsTo
    {
        return $this->belongsTo(Exam_Terms::class, 'exam_term_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subjects::class, 'subject_id');
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Marks::class);
    }
}