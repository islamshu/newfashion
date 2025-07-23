<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Schema;

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
    public function scopeOrdered($query)
{
    // تأكد وجود العمود 'order' قبل تنفيذ الفرز
    if (Schema::hasColumn('products', 'order')) {
        return $query->orderBy('order', 'asc');
    }

    // إذا ما موجود العمود رجع الاستعلام بدون فرز خاص
    return $query;
}

}
