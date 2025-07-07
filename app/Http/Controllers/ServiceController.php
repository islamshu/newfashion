<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.services.index', [
            'services' => Service::all(),
        ]);
    }
    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            Service::where('id', $id)->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
    public function edit(Service $service)
    {
        return view('dashboard.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.he' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'description.he' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'order' => 'nullable|integer|min:0',
        ]);
        $data = $request->except('image');
        if ($request->image && $service->icon) {
            Storage::disk('public')->delete($service->icon);
            $data['icon'] = $request->image->store('service', 'public');
        }


        $service->update($data);
        return redirect()->route('features.index')->with('success', __('تم تحديث الخدمة بنجاح'));
    }
}
