<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_no', 'patient_id', 'doctor_id',
        'type', 'diagnosis', 'from_date', 'to_date', 'recommendations'
    ];

    protected $casts = [
        'from_date' => 'date',
        'to_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
