<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'image_ar',
        'image_he',
        'link',
        'status',
        'order',
    ];
    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order', 'asc');
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
