<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BloodDonor extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_code', 'name', 'gender', 'age', 'blood_group',
        'mobile', 'email', 'address', 'last_donated_at', 'status', 'medical_notes'
    ];

    protected $casts = [
        'last_donated_at' => 'date',
    ];

    public function donations()
    {
        return $this->hasMany(BloodInventory::class, 'donor_id');
    }
}
