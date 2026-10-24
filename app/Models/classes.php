<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class classes extends Model
{
    protected $table = 'classes';
    protected $fillable = ['name', 'numeric_level', 'next_class_id'];

    public function nextClass(): BelongsTo {
        return $this->belongsTo(classes::class, 'next_class_id');
    }

    public function sections(): HasMany {
        return $this->hasMany(Sections::class, 'class_id');
    }
}
