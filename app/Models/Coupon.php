<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'is_active',
        'is_global',
        'applicable_categories',
        'applicable_products',
        'per_user_limit', 
    ];


    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'applicable_categories' => 'array',
        'applicable_products' => 'array',
    ];

    public function isCurrentlyActive(): bool
    {
        return $this->is_active
            && $this->start_date->startOfDay() <= now()
            && $this->end_date->endOfDay() >= now();
    }


    public function isValid(): bool
{
    return $this->is_active
        && ($this->usage_limit === null || $this->used_count < $this->usage_limit)
        && ($this->start_date === null || $this->start_date->startOfDay() <= now())
        && ($this->end_date === null || $this->end_date->endOfDay() >= now());
}


    public function calculateDiscount($subtotal)
    {
        if (!$this->isValid() || ($this->min_order_amount && $subtotal < $this->min_order_amount)) {
            return 0;
        }

        return $this->discount_type === 'percentage'
            ? $subtotal * ($this->discount_value / 100)
            : min($this->discount_value, $subtotal);
    }
    public function usages()
    {
        return $this->hasMany(CouponUsage::class);
    }
}
