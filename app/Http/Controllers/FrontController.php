<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Front\Slider;
use App\Models\Product;
use Inertia\Inertia;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->take(8)->get();
        $bestSellingProducts = Product::take(6)->get();
        $categories = Category::get();
        $sliders = Slider::active()->get();

        return view('layouts.frontend');
    }

    public function brands() {
        return Inertia::render('Brands');
    }

    public function shop() {
        return Inertia::render('Shop');
    }

    public function contact() {
        return Inertia::render('Contact');
    }
}
