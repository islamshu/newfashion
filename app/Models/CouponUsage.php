<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class CouponUsage extends Model
{
    protected $fillable = ['client_id','coupon_id', 'coupon_code', 'discount','order_id'];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
