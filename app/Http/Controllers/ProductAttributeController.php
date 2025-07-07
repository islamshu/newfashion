<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Validator;

class ProductAttributeController extends Controller
{
    public function index()
    {
        $attributes = ProductAttribute::orderBy('type')->get();
        return view('dashboard.products.product_attributes', compact('attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:color,size',
            'value.ar' => 'required|string|max:255',
            'value.he' => 'nullable|string|max:255',
        ]);

        ProductAttribute::create([
            'type' => $request->type,
            'value' => $request->value,
            'code' => $request->code, // Assuming 'code' is a new field you want to add
        ]);

        return response()->json(['success' => 'تم إضافة الخاصية بنجاح']);
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $request->validate([
            'type' => 'required|in:color,size',
            'value.ar' => 'required|string|max:255',
            'value.he' => 'nullable|string|max:255',
        ]);

        $productAttribute->update([
            'type' => $request->type,
            'value' => $request->value,
            'code' => $request->code, // Assuming 'code' is a new field you want to add

        ]);

        return response()->json(['success' => 'تم تحديث الخاصية بنجاح']);
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();
        return response()->json(['success' => __('تم حذف الخاصية بنجاح')]);
    }
}
