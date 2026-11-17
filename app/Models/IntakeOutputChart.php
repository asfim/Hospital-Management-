<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IntakeOutputChart extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id', 'recorded_at', 'intake_type', 'intake_amount_ml',
        'output_type', 'output_amount_ml', 'recorded_by', 'notes'
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'intake_amount_ml' => 'decimal:2',
        'output_amount_ml' => 'decimal:2',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
