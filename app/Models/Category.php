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
        'parent_id'
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
        return $this->hasMany(Category::class, 'parent_id');
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
    
    /**
     * سكوب للتصنيفات المفعلة
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
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