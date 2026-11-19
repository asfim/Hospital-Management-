<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'item_name',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Virtual Accessors for quantity, unit_price, total
     */
    public function getQuantityAttribute()
    {
        return 1;
    }

    public function getUnitPriceAttribute()
    {
        return $this->amount;
    }

    public function getTotalAttribute()
    {
        return $this->amount;
    }
}
