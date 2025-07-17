<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'color_id'   => 'nullable|exists:product_attributes,id',
            'size_id'    => 'nullable|exists:product_attributes,id',
        ]);

        // منطق الإضافة إلى السلة — يمكن تخصيصه حسب النظام
        $cart = session()->get('cart', []);

        $key = $request->product_id . '-' . $request->color_id . '-' . $request->size_id;
        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $request->quantity;
        } else {
            $cart[$key] = [
                'product_id' => $request->product_id,
                'color_id'   => $request->color_id,
                'size_id'    => $request->size_id,
                'quantity'   => $request->quantity,
            ];
        }
        session()->put('cart', $cart);

        return response()->json([
            'message' => 'تمت الإضافة للسلة بنجاح!',
            'cart_count' => count($cart), // أو حسب العدد الفعلي للعناصر
        ]);
    }
    public function mini()
    {
        // لو كنت تخزن السلة في الجلسة مثلاً
        $cart = session('cart', []);
        // احسب الإجماليات
        $subTotal = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            $subTotal += $product->price * $item['quantity'];
        }

        // $discount = $subTotal * 0.2; // خصم 20% مثال


        return view('frontend.partials.cart-mini', compact('cart',   'subTotal'));
    }
    public function checkout()
    {
        $cart = session()->get('cart', []);

        $subtotal = 0;
        foreach ($cart as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }
        $tax = 0; // فرضاً 5% ضريبة
        $totalInclTax = $subtotal + $tax;
        $total = $totalInclTax; // لو في تكاليف أخرى ممكن تضيفها

        return view('frontend.checkout', compact('cart', 'subtotal', 'tax', 'totalInclTax', 'total'));
    }
    public function applyCoupon(Request $request)
    {
        $code = trim($request->input('code'));
        $cart = session('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $subtotal += $product->price * $item['quantity'];
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return response()->json(['error' => __('الكوبون غير صالح أو منتهي.')], 422);
        }

        $discount = $coupon->calculateDiscount($subtotal);
        $tax = 0; // أو حسب إعداداتك
        $total = $subtotal + $tax - $discount;

        Session::put('applied_coupon', [
            'code' => $coupon->code,
            'discount' => $discount,
            'label' => __('خصم الكوبون') . ': ' . $coupon->code,
        ]);

        return response()->json([
            'success' => true,
            'discount' => number_format($discount, 2),
            'discountLabel' => __('خصم الكوبون') . ': ' . $coupon->code,
            'subtotal' => number_format($subtotal, 2),
            'tax' => number_format($tax, 2),
            'totalInclTax' => number_format($subtotal + $tax, 2),
            'total' => number_format($total, 2),
        ]);
    }
    public function removeCoupon()
    {
        session()->forget('applied_coupon');

        $cart = session('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            $subtotal += $product->price * $item['quantity'];
        }

        $tax = 0;
        $total = $subtotal + $tax;

        return response()->json([
            'success' => true,
            'subtotal' => number_format($subtotal, 2),
            'tax' => number_format($tax, 2),
            'totalInclTax' => number_format($subtotal + $tax, 2),
            'total' => number_format($total, 2),
        ]);
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);

        $index = $request->product_id;

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // إعادة ترتيب الفهارس
            session()->put('cart', $cart);
        }

        // حساب الإجمالي من جديد
        $subTotal = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            $subTotal += $product->price * $item['quantity'];
        }

        $cartHtml = view('frontend.partials.cart-mini', compact('cart', 'subTotal'))->render();

        return response()->json([
            'cart_html' => $cartHtml,
            'cart_count' => count($cart),
        ]);
    }
    public function removeItem(Request $request)
    {
        $index = $request->input('index');
        $cart = session()->get('cart', []);

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // إعادة ترتيب المفاتيح
            session()->put('cart', $cart);
        }

        // احسب المجموع الفرعي، الضريبة، الإجمالي (هنا مثال بسيط)
        $subtotal = 0;
        foreach ($cart as $item) {
            $product = \App\Models\Product::find($item['product_id']);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }
        $tax = 0; // 5% ضريبة كمثال
        $total = $subtotal + $tax;

        return response()->json([
            'html' => view('frontend.partials.cart_summary', compact('cart'))->render(),
            'subtotal' => number_format($subtotal, 2),
            'tax' => number_format(0, 2),
            'totalExclTax' => number_format($subtotal, 2), // ممكن تحسب فرق إذا موجود
            'totalInclTax' => number_format($total, 2),
            'total' => number_format($total, 2),
        ]);
    }
}
