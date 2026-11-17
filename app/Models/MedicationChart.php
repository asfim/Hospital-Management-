<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicationChart extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id', 'medicine_name', 'dosage', 'frequency',
        'route', 'start_date', 'end_date', 'instructions', 'status', 'prescribed_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function prescriber()
    {
        return $this->belongsTo(Doctor::class, 'prescribed_by');
    }

    public function administrations()
    {
        return $this->hasMany(MedicationAdministration::class);
    }
}
