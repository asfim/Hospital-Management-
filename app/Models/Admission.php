<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_no', 'patient_id', 'doctor_id', 'referred_by',
        'ward_id', 'bed_id', 'admission_date', 'discharge_date',
        'admission_reason', 'provisional_diagnosis', 'final_diagnosis',
        'status', 'total_deposit', 'total_billed', 'total_paid', 'total_due',
        'created_by'
    ];

    protected $casts = [
        'admission_date' => 'datetime',
        'discharge_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function bed()
    {
        return $this->belongsTo(Bed::class);
    }

    public function bedTransfers()
    {
        return $this->hasMany(BedTransfer::class);
    }

    public function dailyCharges()
    {
        return $this->hasMany(DailyCharge::class);
    }

    public function vitals()
    {
        return $this->hasMany(PatientVital::class);
    }

    public function nursingNotes()
    {
        return $this->hasMany(NursingNote::class);
    }

    public function medicationCharts()
    {
        return $this->hasMany(MedicationChart::class);
    }

    public function dischargeSummary()
    {
        return $this->hasOne(DischargeSummary::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
