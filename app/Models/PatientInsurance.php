<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatientInsurance extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'insurance_company_id', 'policy_number',
        'coverage_amount', 'expiry_date', 'status', 'notes'
    ];

    protected $casts = [
        'coverage_amount' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function company()
    {
        return $this->belongsTo(InsuranceCompany::class, 'insurance_company_id');
    }
}
