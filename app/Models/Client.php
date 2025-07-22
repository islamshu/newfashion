<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'otp',
        'is_active',
    ];



    protected $hidden = [
        'password',
        'otp',
    ];
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'client_id', 'product_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'client_id');
    }
    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class);
    }
    public function hasPurchasedProduct($productId)
    {
        return $this->orders()
            ->where('status', 'completed')
            ->whereHas('items', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->exists();
    }
    public function hasReviewedProduct($productId)
    {
        return $this->ratings()->where('product_id', $productId)->exists();
    }
    public function ratings()
{
    return $this->hasMany(Rating::class, 'client_id');
}
}
