<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guardians extends Model
{
    protected $fillable = [
        'father_name', 'father_phone', 'father_profession',
        'mother_name', 'mother_phone', 'mother_profession',
        'emergency_contact_name', 'emergency_contact_phone',
        'emergency_relation', 'guardian_email', 'residential_address'
    ];

    public function students(): HasMany {
        return $this->hasMany(Students::class,'guardian_id');
    }
}