<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id', 'charge_date', 'charge_type',
        'description', 'amount', 'created_by'
    ];

    protected $casts = [
        'charge_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
