<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCouponRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:coupons,code,' . $this->coupon->id,
            'discount_type' => ['required', Rule::in(['percentage', 'fixed_amount'])],
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
            'is_global' => 'boolean',
            'applicable_categories' => 'nullable|json',
            'applicable_products' => 'nullable|json',
        ];
    }
}
