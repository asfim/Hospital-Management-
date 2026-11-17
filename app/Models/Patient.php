<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'name', 'photo', 'gender', 'dob', 'age', 
        'marital_status', 'occupation', 'blood_group', 'mobile',
        'email', 'nid', 'guardian_name', 'guardian_mobile',
        'address', 'emergency_contact', 'emergency_contact_relation',
        'notes', 'allergies', 'medical_history'
    ];

    public function admissions()
    {
        return $this->hasMany(Admission::class)->latest();
    }

    public function currentAdmission()
    {
        return $this->hasOne(Admission::class)->where('status', 'admitted');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class)->latest();
    }

    public function visits()
    {
        return $this->hasMany(Visit::class)->latest();
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class)->latest();
    }

    public function diagnosticOrders()
    {
        return $this->hasMany(DiagnosticOrder::class)->latest();
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class)->latest();
    }

    public function vitals()
    {
        return $this->hasMany(PatientVital::class)->latest('recorded_at');
    }

    public function emergencyCases()
    {
        return $this->hasMany(EmergencyCase::class)->latest();
    }

    public function surgeries()
    {
        return $this->hasMany(Surgery::class)->latest();
    }

    public function pharmacySales()
    {
        return $this->hasMany(PharmacySale::class)->latest();
    }

    public function insurances()
    {
        return $this->hasMany(PatientInsurance::class);
    }

    public function certificates()
    {
        return $this->hasMany(MedicalCertificate::class)->latest();
    }
}
