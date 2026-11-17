<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicationAdministration extends Model
{
    use HasFactory;

    protected $fillable = [
        'medication_chart_id', 'scheduled_time', 'administered_at',
        'administered_by', 'status', 'notes'
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
        'administered_at' => 'datetime',
    ];

    public function chart()
    {
        return $this->belongsTo(MedicationChart::class, 'medication_chart_id');
    }

    public function administrator()
    {
        return $this->belongsTo(User::class, 'administered_by');
    }
}
