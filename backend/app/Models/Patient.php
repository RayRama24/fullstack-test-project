<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'medical_record_no',
        'nik',
        'nik_hash',
        'email',
        'name',
        // 'birth_date'
        'address'
    ];

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
