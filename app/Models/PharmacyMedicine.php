<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PharmacyMedicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'generic_name', 'category', 'dosage_form',
        'strength', 'manufacturer', 'unit_price', 'purchase_price',
        'reorder_level', 'status', 'notes'
    ];

    public function batches()
    {
        return $this->hasMany(MedicineBatch::class, 'medicine_id');
    }

    public function activeBatches()
    {
        return $this->hasMany(MedicineBatch::class, 'medicine_id')
            ->where('quantity_available', '>', 0)
            ->where('expiry_date', '>=', now()->toDateString())
            ->orderBy('expiry_date', 'asc');
    }

    public function totalStock()
    {
        return $this->batches()->sum('quantity_available');
    }
}
