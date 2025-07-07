<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    /**
     * الحقول التي يمكن تعبئتها جماعياً
     */
    protected $fillable = [
        'title',
        'description',
        'icon',
        'order',
    ];

    /**
     * الحقول المترجمة
     */
    public $translatable = [
        'title',
        'description',
    ];
     public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
