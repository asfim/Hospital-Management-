<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bed extends Model
{
    use HasFactory;

    protected $fillable = [
        'ward_id', 'bed_number', 'type', 'daily_charge',
        'status', 'current_admission_id', 'notes'
    ];

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function currentAdmission()
    {
        return $this->belongsTo(Admission::class, 'current_admission_id');
    }

    public function transfers()
    {
        return $this->hasMany(BedTransfer::class, 'to_bed_id');
    }
}
