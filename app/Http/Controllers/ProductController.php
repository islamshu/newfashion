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
            'category_id' => 'required|exists:categories,id',
            'variations' => 'required|array|min:1',
            'variations.*.stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|max:2048',
            'thumbnails.*' => 'nullable|image|max:2048',
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
        $product->category_id = $request->category_id;
        $product->is_featured = $request->has('is_featured');
        $product->status = $request->has('status');

        // تعيين أول صورة من الثامب كـ صورة رئيسية للمنتج
        if ($request->hasFile('thumbnails') && count($request->file('thumbnails')) > 0) {
            $firstThumb = $request->file('thumbnails')[0];
            $mainImagePath = $firstThumb->store('products/thumbnails', 'public');
            $product->image = $mainImagePath;
        }

        $product->save();

        // حفظ باقي صور الثامب (بما فيها الأولى لو أردت)
        if ($request->hasFile('thumbnails')) {
            foreach ($request->file('thumbnails') as $thumb) {
                $path = $thumb->store('products/thumbnails', 'public');
                $product->thumbnails()->create(['image' => $path]);
            }
        }

        // حفظ صور المنتج الإضافية
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products/images', 'public');
                $product->images()->create(['image' => $path]);
            }
        }

        // حفظ المتغيرات
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

    // تحديث البيانات الأساسية
    $product->setTranslations('name', $request->input('name'));
    $product->setTranslations('description', $request->input('description', []));
    $product->setTranslations('short_description', $request->input('short_description', []));

    $product->price = $request->price;
    $product->sku = $request->sku ?? $product->sku;
    $product->category_id = $request->category_id;
    $product->is_featured = $request->has('is_featured');
    $product->status = $request->has('status');
    $product->save();

    // إدارة الصور المحذوفة (القديمة)
    if ($request->has('deleted_images')) {
        foreach ($request->deleted_images as $imageId) {
            $image = $product->images()->find($imageId);
            if ($image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
        }
    }

    // إضافة الصور الإضافية الجديدة
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            $path = $imageFile->store('products/images', 'public');
            $product->images()->create(['image' => $path]);
        }
    }

    // إدارة الصور المصغرة المحذوفة (القديمة)
    if ($request->has('deleted_thumbnails')) {
        foreach ($request->deleted_thumbnails as $thumbnailId) {
            $thumbnail = $product->thumbnails()->find($thumbnailId);
            if ($thumbnail) {
                Storage::disk('public')->delete($thumbnail->image);
                $thumbnail->delete();
            }
        }
    }

    // إضافة الصور المصغرة الجديدة
    if ($request->hasFile('thumbnails')) {
        foreach ($request->file('thumbnails') as $thumbFile) {
            $path = $thumbFile->store('products/thumbnails', 'public');
            $product->thumbnails()->create(['image' => $path]);
        }
    }

    // إدارة المتغيرات
    $product->variations()->delete(); // حذف القديمة
    foreach ($request->variations as $variation) {
        // التحقق من وجود اللون والمقاس قبل الإضافة
        if (empty($variation['color_id']) || empty($variation['size_id'])) {
            $product->variations()->create([
                'color_id' => $variation['color_id'] ?? null,
                'size_id' => $variation['size_id'] ?? null,
                'stock' => $variation['stock']
            ]);
        }
    }

    return redirect()->route('products.index')->with('success', __('تم تحديث المنتج بنجاح'));
}


    public function destroy(Product $product)
    {
        Storage::delete($product->image);
        $product->delete();
        return back()->with('success', 'تم الحذف بنجاح');
    }
}
