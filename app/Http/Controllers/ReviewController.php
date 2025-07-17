<?php
namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->get();
        return view('dashboard.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('dashboard.reviews.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'job.ar' => 'nullable|string|max:255',
            'job.he' => 'nullable|string|max:255',
            'stars' => 'required|integer|min:1|max:5',
            'description.ar' => 'required|string',
            'description.he' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        Review::create($data);

        return redirect()->route('reviews.index')->with('success', __('تمت الإضافة بنجاح'));
    }

    public function edit(Review $review)
    {
        return view('dashboard.reviews.form', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'job.ar' => 'nullable|string|max:255',
            'job.he' => 'nullable|string|max:255',
            'stars' => 'required|integer|min:1|max:5',
            'description.ar' => 'required|string',
            'description.he' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($review->image) {
                Storage::disk('public')->delete($review->image);
            }
            $data['image'] = $request->file('image')->store('reviews', 'public');
        }

        $review->update($data);

        return redirect()->route('reviews.index')->with('success', __('تم التحديث بنجاح'));
    }

    public function destroy(Review $review)
    {
        if ($review->image) {
            Storage::disk('public')->delete($review->image);
        }

        $review->delete();

        return redirect()->back()->with('success', __('تم الحذف بنجاح'));
    }
}
