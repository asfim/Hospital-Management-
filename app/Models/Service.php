<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'badge',
        'badge_color',
        'icon',
        'icon_color',
        'gradient',
        'short_description',
        'description',
        'points',
        'contact_number',
        'emergency_button_text',
        'emergency_button_link',
        'image',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'points' => 'array',
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }
}
