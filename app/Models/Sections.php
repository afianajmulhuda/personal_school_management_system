<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sections extends Model
{
    protected $table = 'sections';
    protected $fillable = ['campus_id', 'class_id', 'name', 'capacity', 'room_number'];

    public function campus(): BelongsTo {
        return $this->belongsTo(Campus::class);
    }

    public function classes(): BelongsTo {
        return $this->belongsTo(classes::class, 'class_id');
    }

    public function enrollments(): HasMany {
        return $this->hasMany(Student_Enrollments::class);
    }
    
}