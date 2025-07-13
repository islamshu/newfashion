<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Banner extends Model
{
    use HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'button_text',
        'image',
        'link',
        'order',
        'status',
    ];

    public $translatable = ['title', 'description', 'button_text'];
     public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('order', 'asc');
    }
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
