<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'color',
        'size',
        'image',
        'quantity',
        'price',
        'total',
    ];

    /**
     * علاقة العنصر مع الطلب الرئيسي
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function colorAttr()
    {
        return $this->belongsTo(ProductAttribute::class, 'color', 'id');
    }
    public function sizeAttr()
    {
        return $this->belongsTo(ProductAttribute::class, 'size', 'id');
    }
}
