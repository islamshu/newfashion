<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.index')->with('pages', Page::orderby('id', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.create')->with('page', null);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'text' => 'required|array',
        ]);

        // استخلاص اللغة الافتراضية، أو اجعلها ثابتة
        $slugSource = $data['title']['ar'] ?? reset($data['title']);

        $data['slug'] = Str::slug($slugSource);

        // تأكد من فريدة الـ slug
        $originalSlug = $data['slug'];
        $i = 1;
        while (Page::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $i++;
        }

        Page::create($data);

        return redirect()->route('pages.index')->with('success', __('تم إضافة الصفحة بنجاح.'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('dashboard.pages.create')->with('page', $page);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'text' => 'required|array',
        ]);

        // توليد slug تلقائياً من العنوان (اللغة الافتراضية 'ar' مثلاً)
        $baseSlug = Str::slug($data['title']['ar']); // عدّل حسب اللغة المطلوبة

        // تحقق من تفرد slug وأضف رقم في حالة التكرار
        $slug = $baseSlug;
        $counter = 1;
        while (Page::where('slug', $slug)->where('id', '!=', $page->id)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // أضف الـ slug إلى البيانات
        $data['slug'] = $slug;

        $page->update($data);

        return redirect()->route('pages.index')->with('success', __('تم تحديث الصفحة بنجاح.'));
    }
}
