<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariation extends Model
{
    protected $fillable = ['product_id', 'color_id', 'size_id', 'stock'];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
