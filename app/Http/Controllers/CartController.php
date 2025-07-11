<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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

        $discount = $subTotal * 0.2; // خصم 20% مثال
        $total = $subTotal - $discount;

        return view('frontend.partials.cart-mini', compact('cart', 'subTotal', 'discount', 'total'));
    }
}
