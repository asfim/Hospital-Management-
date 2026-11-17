<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BirthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_no', 'patient_id', 'baby_name', 'gender',
        'birth_date', 'birth_time', 'weight_kg', 'mother_name',
        'father_name', 'doctor_id', 'remarks'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'weight_kg' => 'decimal:2',
    ];

    public function mother()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
