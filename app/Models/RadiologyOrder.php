<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RadiologyOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no', 'patient_id', 'doctor_id', 'admission_id',
        'test_name', 'modality', 'clinical_indication', 'amount', 'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function report()
    {
        return $this->hasOne(RadiologyReport::class);
    }
}
