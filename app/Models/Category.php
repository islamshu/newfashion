<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;
    
    /**
     * الحقول التي يمكن تعبئتها جماعياً
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'status',
        'parent_id',
        'is_featured',
    ];
    
    /**
     * الحقول المترجمة
     */
    public $translatable = [
        'name',
    ];
    
    /**
     * علاقة التصنيفات الفرعية
     */
   public function children()
{
    return $this->hasMany(Category::class, 'parent_id')->with('children');
}
    
    /**
     * علاقة التصنيف الأب
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    
    /**
     * سكوب للتصنيفات الرئيسية (بدون أب)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }
    public function scopeChiled($query)
    {
        return $query->whereNotNull('parent_id');
    }
    /**
     * سكوب للتصنيفات المفعلة
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatcher($query)
    {
        return $query->where('is_featured', true);
    }
    
    /**
     * الوصول إلى صورة التصنيف مع مسار كامل
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : asset('images/default-category.png');
    }
    
    /**
     * إنشاء slug تلقائي عند الحفظ
     */
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($model) {
            // إنشاء slug من الاسم العربي إذا كان slug فارغاً أو الاسم العربي تغير
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->getTranslation('name', 'ar'));
            }
        });
    }
    /**
     * Get all of the comments for the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    /**
     * حذف الصورة عند حذف التصنيف
     */
    protected static function booted()
    {
        static::deleted(function ($category) {
            if ($category->image) {
                Storage::delete($category->image);
            }
        });
    }
}