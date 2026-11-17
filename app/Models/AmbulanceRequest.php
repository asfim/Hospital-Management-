<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AmbulanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_no', 'patient_id', 'ambulance_vehicle_id', 'contact_name',
        'contact_phone', 'pickup_location', 'destination', 'distance_km',
        'fare_amount', 'paid_amount', 'status', 'requested_at', 'completed_at', 'notes'
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'completed_at' => 'datetime',
        'fare_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(AmbulanceVehicle::class, 'ambulance_vehicle_id');
    }
}
