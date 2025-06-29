<?php

namespace App\Http\Controllers;

use App\Models\{Product, Category, ProductVariation, ProductAttribute};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        $categories = Category::all();
        return view('dashboard.products.index', compact('products', 'categories'));
    }

    public function ajaxIndex(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('name')) {
            $locale = app()->getLocale();

            $query->where("name->{$locale}", 'like', '%' . $request->name . '%');
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        $products = $query->latest()->paginate(10);

        return response()->json([
            'html' => view('dashboard.products._table', compact('products'))->render(),
        ]);
    }


    public function create()
    {
        $categories = Category::where('status', true)->get();
        $colors = ProductAttribute::where('type', 'color')->get();
        $sizes = ProductAttribute::where('type', 'size')->get();

        return view('dashboard.products.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.ar' => 'required',
            'name.he' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|max:2048',
            'category_id' => 'required|exists:categories,id',
            'variations' => 'required|array|min:1',
            'variations.*.stock' => 'required|integer|min:0',
        ]);

        $product = new Product();
        $product->setTranslations('name', $request->input('name'));
        $product->setTranslations('description', $request->input('description'));
        $product->setTranslations('short_description', $request->input('short_description'));

        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->discount_start = $request->discount_start;
        $product->discount_end = $request->discount_end;
        $product->sku = $request->sku ?? strtoupper(Str::random(10));
        $product->image = $request->file('image')->store('products', 'public');
        $product->category_id = $request->category_id;
        $product->is_featured = $request->has('is_featured');
        $product->status = $request->has('status');

        $product->save();

        foreach ($request->variations as $variation) {
            $product->variations()->create($variation);
        }

        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $colors = ProductAttribute::where('type', 'color')->get();
        $sizes = ProductAttribute::where('type', 'size')->get();

        return view('dashboard.products.edit', compact('product', 'categories', 'colors', 'sizes'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name.ar' => 'required',
            'name.he' => 'required',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'variations' => 'required|array|min:1',
            'variations.*.stock' => 'required|integer|min:0',
        ]);

        $product->setTranslations('name', $request->input('name'));
        $product->setTranslations('description', $request->input('description'));
        $product->setTranslations('short_description', $request->input('short_description'));

        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->discount_start = $request->discount_start;
        $product->discount_end = $request->discount_end;
        $product->sku = $request->sku ?? $product->sku;
        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $product->image = $request->file('image')->store('products');
        }
        $product->category_id = $request->category_id;
        $product->is_featured = $request->has('is_featured');
        $product->status = $request->has('status');

        $product->save();

        $product->variations()->delete();
        foreach ($request->variations as $variation) {
            $product->variations()->create($variation);
        }

        return redirect()->route('products.index')->with('success', 'تم تحديث المنتج');
    }

    public function destroy(Product $product)
    {
        Storage::delete($product->image);
        $product->delete();
        return back()->with('success', 'تم الحذف بنجاح');
    }
}
