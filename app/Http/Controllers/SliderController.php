<?php

namespace App\Http\Controllers;

use App\Models\Slider;
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
            'image_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_he' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image_ar', 'image_he']);

        if ($request->hasFile('image_ar')) {
            $data['image_ar'] = $request->file('image_ar')->store('sliders', 'public');
        }
        if ($request->hasFile('image_he')) {
            $data['image_he'] = $request->file('image_he')->store('sliders', 'public');
        }

        $slider = Slider::create($data);
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
            'image_ar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_he' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->except(['image_ar','image_he']);

        if ($request->hasFile('image_ar')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($slider->image_ar && Storage::disk('public')->exists($slider->image_ar)) {
                Storage::disk('public')->delete($slider->image_ar);
            }
            $data['image_ar'] = $request->file('image_ar')->store('sliders', 'public');
            $slider->image_ar = $data['image_ar'];
        }
        if ($request->hasFile('image_he')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($slider->image_he && Storage::disk('public')->exists($slider->image_he)) {
                Storage::disk('public')->delete($slider->image_he);
            }
            $data['image_he'] = $request->file('image_he')->store('sliders', 'public');
            $slider->image_he = $data['image_he'];
        }
        
        $slider->update($data);

        return redirect()->route('sliders.index')->with('success', __('تم تحديث السلايدر بنجاح'));
    }
    public function updateOrder(Request $request)
{
    foreach ($request->order as $index => $id) {
        Slider::where('id', $id)->update(['order' => $index]);
    }

    return response()->json(['success' => true]);
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
