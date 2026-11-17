<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DeathRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'record_no', 'patient_id', 'admission_id',
        'death_date', 'death_time', 'cause_of_death', 'doctor_id', 'remarks'
    ];

    protected $casts = [
        'death_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
