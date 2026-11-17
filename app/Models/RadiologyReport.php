<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RadiologyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'radiology_order_id', 'patient_id', 'radiologist_id',
        'findings', 'impression', 'image_path', 'status'
    ];

    public function order()
    {
        return $this->belongsTo(RadiologyOrder::class, 'radiology_order_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function radiologist()
    {
        return $this->belongsTo(User::class, 'radiologist_id');
    }
}
