<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('dashboard.banners.index', compact('banners'));
    }

    public function create()
    {
        if (Banner::count() >= 2) {
            return redirect()->route('banners.index')->with('error', __('لا يمكن إضافة أكثر من 2 بانرات.'));
        }

        // تمرير متغير فارغ لتجنب undefined
        $banner = null;

        return view('dashboard.banners.create', compact('banner'));
    }
    public function update_status_banner(Request $request)
    {
        $slider = Banner::findOrFail($request->banner_id);
        $slider->status = !$slider->status; // Toggle status
        $slider->save();

        return response()->json(['success' => true, 'status' => $slider->status]);
    }
    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Banner::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        if (Banner::count() >= 2) {
            return redirect()->route('banners.index')->with('error',__( 'لا يمكن إضافة أكثر من 2 بانرات.'));
        }

        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'nullable|array',
            'button_text' => 'nullable|array',
            'link' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'image' => 'required|image|max:2048',
        ]);

        $data['image'] = $request->file('image')->store('banners', 'public');
     

        Banner::create($data);
        return redirect()->route('banners.index')->with('success',__('تم إضافة البانر بنجاح.'));
    }

    public function edit(Banner $banner)
    {
        return view('dashboard.banners.create', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $data = $request->validate([
            'title' => 'required|array',
            'description' => 'nullable|array',
            'button_text' => 'nullable|array',
            'link' => 'nullable|string',
            'order' => 'nullable|integer',
            'status' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إن وجدت
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image')->store('banners', 'public');
        }


        $banner->update($data);
        return redirect()->route('banners.index')->with('success', __('تم تحديث البانر بنجاح.'));
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();
        return redirect()->route('banners.index')->with('success', __('تم حذف البانر بنجاح.'));
    }
}
