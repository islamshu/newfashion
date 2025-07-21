<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'message' => 'nullable|string',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => __('السلة فارغة.'),
            ], 422);
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue;
            $subtotal += $product->price * $item['quantity'];
        }

        $tax = 0;
        $discount = 0;
        $code = null;
        $coupon = null;

        if (session()->has('applied_coupon') && is_array(session('applied_coupon'))) {
            $applied = session('applied_coupon');
            $code = $applied['code'];
            $discount = $applied['discount'];
            $coupon = Coupon::where('code', $code)->first();

            if (!$coupon || !$coupon->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => __('الكوبون غير صالح أو منتهي.'),
                ], 422);
            }

            if ($coupon->min_order_amount && $subtotal < $coupon->min_order_amount) {
                return response()->json([
                    'success' => false,
                    'message' => __('يجب أن يكون المجموع أكبر من :amount ₪ لاستخدام هذا الكوبون.', ['amount' => $coupon->min_order_amount]),
                ], 422);
            }

            if ($coupon->per_user_limit) {
                $userId = auth('client')->id();
                $usageCount = CouponUsage::where('coupon_id', $coupon->id)
                    ->where('client_id', $userId)
                    ->count();

                if ($usageCount >= $coupon->per_user_limit) {
                    return response()->json([
                        'success' => false,
                        'message' => __('لقد تجاوزت الحد الأقصى لاستخدام هذا الكوبون.'),
                    ], 422);
                }
            }
        }

        $total = $subtotal + $tax - $discount;

        try {
            DB::beginTransaction();

            $order = Order::create([
                'code' => 'ORD-' . strtoupper(uniqid()),
                'client_id' => auth('client')->id(),
                'fname' => $validated['fname'],
                'lname' => $validated['lname'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postcode' => '00972',
                'notes' => $validated['message'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'coupon_code' => $code,
                'discount' => $discount,
                'status' => 'pending',
            ]);

            if ($coupon) {
                CouponUsage::create([
                    'client_id' => auth('client')->id(),
                    'coupon_id' => $coupon->id,
                    'order_id' => $order->id,
                    'coupon_code' => $code,
                    'discount' => $discount,
                ]);
                $coupon->increment('used_count');
            }

            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);
                if (!$product) continue;

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'color' => $item['color_id'] ?? null,
                    'size' => $item['size_id'] ?? null,
                    'image' => $product->thumbnails->first()->image ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                    'total' => $product->price * $item['quantity'],
                ]);

                $product->variations()
                    ->where('color_id', $item['color_id'] ?? null)
                    ->where('size_id', $item['size_id'] ?? null)
                    ->decrement('stock', $item['quantity']);
            }

            DB::commit();

            session()->forget(['cart', 'applied_coupon']);

            return response()->json([
                'success' => true,
                'message' => __('تم تنفيذ الطلب بنجاح.'),
                'order_code' => $order->code,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);

            return response()->json([
                'success' => false,
                'message' => __('حدث خطأ أثناء معالجة الطلب. يرجى المحاولة لاحقًا.'),
            ], 500);
        }
    }
}
