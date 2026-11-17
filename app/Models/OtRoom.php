<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OtRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_number', 'name', 'type', 'daily_charge',
        'hourly_rate', 'status', 'equipment_details'
    ];

    public function surgeries()
    {
        return $this->hasMany(Surgery::class);
    }
}
