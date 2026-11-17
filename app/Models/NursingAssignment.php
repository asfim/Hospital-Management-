<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NursingAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id', 'nurse_id', 'date', 'shift', 'status'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }
}
