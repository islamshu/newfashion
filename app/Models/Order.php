<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'fname',
        'lname',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
        'notes',
        'subtotal',
        'tax',
        'total',
        'coupon_code',
        'discount',
        'status',
        'code',
        'client_id',
        'city_data'
    ];
    protected $casts = [
        'city_data' => 'array',
    ];


    /**
     * علاقة الطلب مع العناصر (المنتجات داخل الطلب)
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
