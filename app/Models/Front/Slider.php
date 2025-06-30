<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;
    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'button_text',
        'button_link',
        'status',
        'order',
    ];
    public $translatable = [
        'title',
        'subtitle',
        'button_text',
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
