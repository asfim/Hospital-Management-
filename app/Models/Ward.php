<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'code', 'type', 'floor', 'gender_type',
        'capacity', 'daily_charge', 'status', 'description'
    ];

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

    public function availableBeds()
    {
        return $this->hasMany(Bed::class)->where('status', 'available');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class);
    }
}
