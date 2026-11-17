<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id', 'batch_no', 'expiry_date',
        'quantity_in', 'quantity_available', 'purchase_rate', 'sale_rate'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'purchase_rate' => 'decimal:2',
        'sale_rate' => 'decimal:2',
    ];

    public function medicine()
    {
        return $this->belongsTo(PharmacyMedicine::class, 'medicine_id');
    }
}
