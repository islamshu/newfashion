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

        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $subtotal += $product->price * $item['quantity'];
        }

        $tax = 0;
        $code = null;
        $discount = 0;

        if (session()->has('applied_coupon') && is_array(session('applied_coupon'))) {
            $coupon = session('applied_coupon');
            $code = $coupon['code'];
            $discount = $coupon['discount'];
        }

        $total = $subtotal + $tax - $discount;

        try {
            DB::beginTransaction();

            // إنشاء الطلب
            $order = Order::create([
                'code' => 'ORD-' . uniqid(),
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
            if ($code != null) {
                $coupon = Coupon::where('code', $code)->first();

                if (!$coupon || !$coupon->isValid()) {
                    return response()->json([
                        'success' => false,
                        'message' => __('الكوبون غير صالح أو منتهي.'),
                    ], 500);
                }
                CouponUsage::create([
                    'client_id' => auth('client')->id(),
                    'coupon_id' => $coupon->id,
                    'order_id' => $order->id,
                    'coupon_code' => $code,
                    'discount' => $discount,
                ]);
                $coupon->increment('used_count');
                $coupon->save();
            }

            // عناصر الطلب
            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);

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

            // نجاح العملية
            DB::commit();


            // تفريغ السلة
            session()->forget(['cart', 'applied_coupon']);

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الطلب بنجاح!',
                'order_id' => $order->id,
                'order_code'=>$order->code
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء معالجة الطلب: ' . $e,
            ], 500);
        }
    }
}
