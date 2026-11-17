<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DischargeSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id', 'patient_id', 'doctor_id', 'discharge_date',
        'final_diagnosis', 'condition_on_discharge', 'treatment_given',
        'discharge_medications', 'dietary_advice', 'activity_advice',
        'follow_up_instructions', 'follow_up_date', 'approved_by', 'approved_at'
    ];

    protected $casts = [
        'discharge_date' => 'datetime',
        'follow_up_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
