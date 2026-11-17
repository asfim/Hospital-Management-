<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientVital extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'admission_id', 'emergency_case_id', 'visit_id',
        'systolic_bp', 'diastolic_bp', 'pulse_rate', 'temperature',
        'respiratory_rate', 'spo2', 'blood_sugar', 'weight', 'height', 'bmi',
        'notes', 'recorded_at', 'recorded_by'
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function emergencyCase()
    {
        return $this->belongsTo(EmergencyCase::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
