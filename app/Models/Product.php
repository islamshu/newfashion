<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'description',
        'short_description',
        'price',
        'discount_price',
        'discount_start',
        'discount_end',
        'sku',
        'image',
        'category_id',
        'is_featured',
        'status'
    ];

    public $translatable = ['name', 'description', 'short_description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
}
