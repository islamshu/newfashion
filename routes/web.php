<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

Route::get('/', function () {

  return inertia('Home', ['user' => 'islam']);
})->name('home');
Route::inertia('/about', 'About')->name('about');
Route::get('/products', function () {
  $response = Http::get('www.jasani.ae/products/all/7efedcf0d9bc4cd1b51d971f2cb4cd46');
  dd($response);
  if ($response->successful()) {
    // تحويل البيانات إلى Collection
    $products = collect($response->json());

    // تصفية المنتج بحسب الـ id
    $product = $products->firstWhere('id', 4784);
    dd($product);
    // التأكد من وجود المنتج
    if ($product) {
      dd($product);
      return response()->json($product);
    } else {
      return response()->json(['message' => 'Product not found'], 404);
    }
  }
});

Route::get('/login', [DashbaordController::class, 'login'])->name('login');
Route::post('/login', [DashbaordController::class, 'post_login'])->name('post_login');
Route::get('language/{locale}', [DashbaordController::class, 'change_lang'])->name('language.switch');

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
  Route::get('/', [DashbaordController::class, 'dashboard'])->name('dashboard');
  Route::get('/logout', [DashbaordController::class, 'logout'])->name('logout');
  Route::get('/edit_profile', [DashbaordController::class, 'edit_profile'])->name('edit_profile');
  Route::post('/edit_profile', [DashbaordController::class, 'edit_profile_post'])->name('edit_profile_post');
  Route::post('/add_general', [DashbaordController::class, 'add_general'])->name('add_general');
  Route::get('/setting', [DashbaordController::class, 'setting'])->name('setting');
  Route::resource('categories', CategoryController::class)->except(['show']);
  Route::resource('products', ProductController::class)->except(['show']);
  Route::get('/products/ajax', [ProductController::class, 'ajaxIndex'])->name('products.ajax');
  Route::get('/categories/ajax', [CategoryController::class, 'ajaxIndex'])->name('categories.ajax');
  Route::get('/coupons/ajax', [CouponController::class, 'ajaxIndex'])->name('coupons.ajax');
  Route::resource('product_attributes', ProductAttributeController::class)->except(['show']);
  Route::resource('coupons', CouponController::class)->except(['show']);
Route::get('language_translate/{local}',[DashbaordController::class,'show_translate'])->name('show_translate');
Route::post('/languages/key_value_store',[DashbaordController::class,'key_value_store'])->name('languages.key_value_store');
  
});
