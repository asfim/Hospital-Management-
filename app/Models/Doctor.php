<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'user_id', 'department_id', 'name', 'photo',
        'specialization', 'designation', 'qualification', 'bmdc_reg',
        'mobile', 'email', 'address', 'room_no',
        'consultation_fee', 'ipd_round_charge', 'emergency_charge', 'status'
    ];

    public function getSpecialityAttribute()
    {
        return $this->specialization;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class)->latest();
    }

    public function visits()
    {
        return $this->hasMany(Visit::class)->latest();
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class)->latest();
    }

    public function surgeries()
    {
        return $this->hasMany(Surgery::class, 'lead_surgeon_id')->latest();
    }

    public function emergencyCases()
    {
        return $this->hasMany(EmergencyCase::class)->latest();
    }
}
