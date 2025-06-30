<?php

namespace App\Http\Controllers;

use App\Models\Front\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::get();
        return view('dashboard.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sliders.create');
    }
    public function update_status_slider(Request $request)
    {
        $slider = Slider::findOrFail($request->slider_id);
        $slider->status = !$slider->status; // Toggle status
        $slider->save();

        return response()->json(['success' => true, 'status' => $slider->status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|array',
            'title.*' => 'required|string|max:255',
            'subtitle' => 'nullable|array',
            'subtitle.*' => 'nullable|string|max:255',
            'button_text' => 'nullable|array',
            'button_text.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'button_link' => 'nullable|string',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('sliders', 'public');
        }

        $slider = new Slider();

        // ترجمة الحقول
        $slider->setTranslations('title', $data['title']);
        $slider->setTranslations('subtitle', $data['subtitle'] ?? []);
        $slider->setTranslations('button_text', $data['button_text'] ?? []);

        // الحقول العادية
        $slider->button_link = $data['button_link'] ?? null;

        $slider->image = $data['image'] ?? null;

        $slider->save();

        return redirect()->route('sliders.index')->with('success', __('تم إنشاء السلايدر بنجاح'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider)
    {
        return view('dashboard.sliders.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
{
    $request->validate([
        'title' => 'required|array',
        'title.*' => 'required|string|max:255',
        'subtitle' => 'nullable|array',
        'subtitle.*' => 'nullable|string|max:255',
        'button_text' => 'nullable|array',
        'button_text.*' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'button_link' => 'nullable|string',
      
    ]);

    $data = $request->except('image');

    if ($request->hasFile('image')) {
        // حذف الصورة القديمة إذا كانت موجودة
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }
        $data['image'] = $request->file('image')->store('sliders', 'public');
        $slider->image = $data['image'];
    }

    // تحديث الترجمات
    $slider->setTranslations('title', $data['title']);
    $slider->setTranslations('subtitle', $data['subtitle'] ?? []);
    $slider->setTranslations('button_text', $data['button_text'] ?? []);

    // الحقول العادية
    $slider->button_link = $data['button_link'] ?? null;


    $slider->save();

    return redirect()->route('sliders.index')->with('success', __('تم تحديث السلايدر بنجاح'));
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        if ($slider->image && Storage::disk('public')->exists($slider->image)) {
            Storage::disk('public')->delete($slider->image);
        }
        $slider->delete();
        return redirect()->route('sliders.index')->with('success', __('تم حذف السلايدر بنجاح'));
    }
}
