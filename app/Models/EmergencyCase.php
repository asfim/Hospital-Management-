<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyCase extends Model
{
    use HasFactory;

    protected $fillable = [
        'case_no', 'patient_id', 'doctor_id', 'nurse_id',
        'triage_priority', 'arrival_mode', 'arrival_time',
        'presenting_complaints', 'treatment_given', 'admission_id',
        'status', 'treatment_fee', 'payment_status', 'discharged_at',
        'discharge_notes', 'created_by'
    ];

    protected $casts = [
        'arrival_time' => 'datetime',
        'discharged_at' => 'datetime',
        'treatment_fee' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function vitals()
    {
        return $this->hasMany(PatientVital::class);
    }
}
