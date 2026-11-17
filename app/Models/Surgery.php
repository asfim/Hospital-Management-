<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surgery extends Model
{
    use HasFactory;

    protected $fillable = [
        'surgery_no', 'patient_id', 'admission_id', 'ot_room_id',
        'lead_surgeon_id', 'anesthesiologist_id', 'surgery_name', 'surgery_type',
        'scheduled_start', 'scheduled_end', 'actual_start', 'actual_end',
        'anesthesia_type', 'pre_op_notes', 'op_notes', 'post_op_notes',
        'surgeon_fee', 'anesthesia_fee', 'ot_room_charge', 'total_charge',
        'status', 'payment_status'
    ];

    protected $casts = [
        'scheduled_start' => 'datetime',
        'scheduled_end' => 'datetime',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
        'total_charge' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function room()
    {
        return $this->belongsTo(OtRoom::class, 'ot_room_id');
    }

    public function leadSurgeon()
    {
        return $this->belongsTo(Doctor::class, 'lead_surgeon_id');
    }

    public function anesthesiologist()
    {
        return $this->belongsTo(Doctor::class, 'anesthesiologist_id');
    }

    public function staffTeam()
    {
        return $this->hasMany(SurgeryStaff::class);
    }
}
