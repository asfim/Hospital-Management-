<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'bag_number', 'blood_group', 'component_type', 'donor_id',
        'collected_at', 'expiry_date', 'status', 'storage_location',
        'issued_to_patient_id', 'issued_at'
    ];

    protected $casts = [
        'collected_at' => 'date',
        'expiry_date' => 'date',
        'issued_at' => 'datetime',
    ];

    public function donor()
    {
        return $this->belongsTo(BloodDonor::class, 'donor_id');
    }

    public function issuedToPatient()
    {
        return $this->belongsTo(Patient::class, 'issued_to_patient_id');
    }
}
