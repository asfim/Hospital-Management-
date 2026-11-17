<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicineReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacy_sale_id', 'medicine_id', 'medicine_batch_id',
        'quantity', 'refund_amount', 'reason', 'returned_by'
    ];

    public function sale()
    {
        return $this->belongsTo(PharmacySale::class, 'pharmacy_sale_id');
    }

    public function medicine()
    {
        return $this->belongsTo(PharmacyMedicine::class, 'medicine_id');
    }

    public function batch()
    {
        return $this->belongsTo(MedicineBatch::class, 'medicine_batch_id');
    }

    public function returnedByUser()
    {
        return $this->belongsTo(User::class, 'returned_by');
    }
}
