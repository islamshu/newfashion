<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    public function index(Request $request)
    {

        $coupons = Coupon::paginate(10);
        return view('dashboard.coupons.index', compact('coupons'));
    }
    public function usages(Coupon $coupon)
    {
        $usages = $coupon->usages()->with('client')->latest()->paginate(15);
        return view('dashboard.coupons.usages', compact('coupon', 'usages'));
    }

    public function ajaxIndex(Request $request)
    {
        $query = Coupon::query();

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $coupons = $query->latest()->paginate(10);

        return response()->json([
            'html' => view('dashboard.coupons.partials.table', compact('coupons'))->render(),
        ]);
    }


    public function create()
    {
        return view('dashboard.coupons.create');
    }

    public function store(StoreCouponRequest $request)
    {
        $data = $request->validated();
        $data['applicable_categories'] = json_decode($data['applicable_categories'] ?? '[]', true);
        $data['applicable_products'] = json_decode($data['applicable_products'] ?? '[]', true);

        Coupon::create($data);

        return redirect()->route('coupons.index')
            ->with('success', 'تم إنشاء الكوبون بنجاح');
    }

    public function edit(Coupon $coupon)
    {
        return view('dashboard.coupons.create', compact('coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $data = $request->validated();
        $data['applicable_categories'] = json_decode($data['applicable_categories'] ?? '[]', true);
        $data['applicable_products'] = json_decode($data['applicable_products'] ?? '[]', true);

        $coupon->update($data);

        return redirect()->route('coupons.index')
            ->with('success', 'تم تحديث الكوبون بنجاح');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        return redirect()->route('coupons.index')
            ->with('success', 'تم حذف الكوبون بنجاح');
    }
}
