<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasTranslations, SoftDeletes;

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
        'status',
        'tags',
        'fake_rating_enabled',
        'fake_rating_value',
    ];
    protected $casts = [
        'fake_rating_enabled' => 'boolean',
        'fake_rating_value' => 'float',
    ];
    public $translatable = ['name', 'short_description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumbnails()
    {
        return $this->hasMany(ProductThumbnail::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function isOutOfStock()
    {
        // إذا كان المنتج ليس لديه variations (منتج بسيط بدون خيارات)
        if ($this->variations->isEmpty()) {
            return $this->stock <= 0; // تحقق من المخزون المباشر للمنتج
        }

        // إذا كان لديه variations، نتحقق من مجموع المخزون لجميع المتغيرات
        $totalStock = $this->variations->sum('stock');
        return $totalStock <= 0;
    }
    public function isInWishlist()
    {
        if (!auth('client')->check()) return false;

        return auth('client')->user()->wishlist()->where('product_id', $this->id)->exists();
    }
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    // لحساب متوسط تقييم المنتج (الحقيقي فقط)
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    // لحساب متوسط التقييم الظاهري (إما وهمي أو حقيقي)
    public function displayedRating()
    {
        if ($this->fake_rating_enabled && $this->fake_rating_value !== null) {
            return $this->fake_rating_value;
        }

        return $this->averageRating() ?: 0;
    }
      public function reviews()
    {
        return $this->hasMany(Rating::class);
    }
}
