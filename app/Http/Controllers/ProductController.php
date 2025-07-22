<?php

namespace App\Http\Controllers;

use App\Models\{Product, Category, ProductVariation, ProductAttribute, Rating};
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

    public function trashed()
    {
        // جلب المنتجات المحذوفة فقط باستخدام withTrashed() أو onlyTrashed()
        $products = Product::onlyTrashed()->with('category')->latest()->paginate(10);

        return view('dashboard.products.trashed', compact('products'));
    }
    // استرجاع منتج
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('products.trashed')->with('success', 'تم استرجاع المنتج بنجاح.');
    }

    // حذف نهائي
    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();

        return redirect()->route('products.trashed')->with('success', 'تم حذف المنتج نهائيًا.');
    }

    public function product_rating($id){
        $product = Product::with('reviews')->findOrFail($id);
        return view('dashboard.products.rating')->with('product',$product);
    }
    public function delete_product_rating($id){
        $review = Rating::find($id);
        $review->delete();
        return redirect()->back()->with('success',__('تم الحذف بنجاح'));
    }
    public function create()
    {
        $categories = Category::where('status', true)->get();
        $colors = ProductAttribute::where('type', 'color')->get();
        $sizes = ProductAttribute::where('type', 'size')->get();

        return view('dashboard.products.create', compact('categories', 'colors', 'sizes'));
    }
    public function update_status_product(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->status = $request->status; // Toggle status
        $product->save();

        return response()->json(['success' => true, 'status' => $product->status, 'message' => __('تم تحديث حالة المنتج')]);
    }

    public function update_featured_product(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $product->is_featured = $request->is_featured; // Toggle status
        $product->save();

        return response()->json(['success' => true, 'status' => $product->is_featured, 'message' => __('تم تحديث المنتج')]);
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
            'fake_rating_enabled' => 'nullable|boolean',
            'fake_rating_value' => 'nullable|numeric|between:1,5',
        ]);

        $product = new Product();
        $product->setTranslations('name', $request->input('name'));
        $product->setTranslations('short_description', $request->input('short_description'));

        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->discount_start = $request->discount_start;
        $product->discount_end = $request->discount_end;
        $product->sku = $request->sku ?? strtoupper(Str::random(10));
        $product->category_id = $request->category_id;
        $product->is_featured = $request->has('is_featured');
        $product->status = $request->has('status');
        $product->tags = $this->add_tage($request->input('short_description', []));
        $product->fake_rating_enabled = $request->has('fake_rating_enabled');
        $product->fake_rating_value  = $request->input('fake_rating_value');
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
        $categories = Category::active()->get();
        $colors = ProductAttribute::where('type', 'color')->get();
        $sizes = ProductAttribute::where('type', 'size')->get();

        return view('dashboard.products.edit', compact('product', 'categories', 'colors', 'sizes'));
    }
    public function show($id)
    {
        // جلب المنتج بما في ذلك المحذوفات
        $product = Product::withTrashed()->find($id);

        // إذا لم يتم العثور على المنتج نهائياً (حتى في المحذوفات)
        if (!$product) {
            abort(404);
        }

        $categories = Category::active()->get();
        $colors = ProductAttribute::where('type', 'color')->get();
        $sizes = ProductAttribute::where('type', 'size')->get();

        return view('dashboard.products.show', compact('product', 'categories', 'colors', 'sizes'));
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
            'fake_rating_enabled' => 'nullable|boolean',
            'fake_rating_value' => 'nullable|numeric|between:1,5',
        ]);

        // تحديث البيانات الأساسية
        $product->setTranslations('name', $request->input('name'));
        $product->setTranslations('short_description', $request->input('short_description', []));

        $product->price = $request->price;
        $product->sku = $request->sku ?? $product->sku;
        $product->category_id = $request->category_id;
        $product->is_featured = $request->has('is_featured');
        $product->status = $request->has('status');
        $product->tags = $this->add_tage($request->input('short_description', []));
        $product->fake_rating_enabled = $request->has('fake_rating_enabled');
        $product->fake_rating_value  = $request->input('fake_rating_value');
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
            if (!empty($variation['color_id']) || !empty($variation['size_id'])) {
                $product->variations()->create([
                    'color_id' => $variation['color_id'] ?? null,
                    'size_id' => $variation['size_id'] ?? null,
                    'stock' => $variation['stock']
                ]);
            }
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
    private function add_tage($description)
    {
        $allWords = collect();

        foreach ($description as $lang => $desc) {
            $cleanText = preg_replace('/[^\p{L}\p{N}\s]/u', '', $desc); // إزالة الترقيم
            $words = explode(' ', $cleanText);
            $allWords = $allWords->merge($words);
        }

        $tags = $allWords
            ->filter()        // إزالة الكلمات الفارغة
            ->unique()        // إزالة الكلمات المكررة
            ->values()
            ->implode(',');   // حفظها كنص مفصول بفواصل

        return $tags;
    }
}
