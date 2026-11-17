<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InsuranceCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'contact_person', 'phone', 'email', 'address', 'status'
    ];

    public function patientInsurances()
    {
        return $this->hasMany(PatientInsurance::class);
    }
}
