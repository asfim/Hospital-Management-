<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AmbulanceVehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number', 'vehicle_model', 'type', 'driver_name',
        'driver_phone', 'status', 'standard_fare', 'per_km_rate'
    ];

    public function requests()
    {
        return $this->hasMany(AmbulanceRequest::class);
    }
}
