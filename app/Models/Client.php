<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // إذا تريد تستخدم authentication
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Client extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone_number',
        'password',
        'otp',
    ];



    protected $hidden = [
        'password',
        'otp',
    ];
    public function wishlist()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'client_id', 'product_id');
    }
}
