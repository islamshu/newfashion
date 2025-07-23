<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return view('dashboard.cities.index', compact('cities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.ar' => 'required|string',
            'name.he' => 'required|string',
            'delivery_fee' => 'required|numeric|min:0'
        ]);

        City::create($validated);

        return response()->json(['success' => __('تم الاضافة المدينة بنجاح')]);
    }

    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name.ar' => 'required|string',
            'name.he' => 'required|string',
            'delivery_fee' => 'required|numeric|min:0'
        ]);

        $city->update($validated);

        return response()->json(['success' => __('تم تحديث المدينة بنجاح')]);
    }

    public function destroy(City $city)
    {
        $city->delete();
        return response()->json(['success' => __('City deleted successfully')]);
    }
}