<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
        $categories = Category::main()->paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }

     public function ajaxIndex(Request $request)
    {
        $query = Category::query();

        if ($request->filled('name')) {
            $locale = app()->getLocale();

            $query->where("name->{$locale}", 'like', '%' . $request->name . '%');
        }
        


        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('created_at')) {
            $query->whereDate('created_at', $request->created_at);
        }

        $categories = $query->latest()->paginate(10);

        return response()->json([
            'html' => view('dashboard.categories._table', compact('categories'))->render(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('dashboard.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.he' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|boolean'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        // إنشاء slug من الاسم العربي
        $data['slug'] = Str::slug($request->name['ar']);

        Category::create($data);

        return redirect()->route('categories.index')
            ->with('success', __('تم إنشاء التصنيف بنجاح'));
    }

    public function edit(Category $category)
    {
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('dashboard.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.he' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',
            'status' => 'required|boolean'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا وجدت
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $data['image'] = $request->file('image')->store('categories', 'public');
        }

        // تحديث slug إذا تغير الاسم العربي
        if (
            is_array($category->name) &&
            is_array($request->name) &&
            ($category->name['ar'] ?? null) != ($request->name['ar'] ?? null)
        ) {
            $data['slug'] = Str::slug($request->name['ar']);
        }
        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', __('تم تحديث التصنيف بنجاح'));
    }

    public function destroy(Category $category)
    {
        // حذف الصورة إذا وجدت
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', __('تم حذف التصنيف بنجاح'));
    }
}
