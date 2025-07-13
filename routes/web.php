<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SliderController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

Route::get('/', function () {

  return view('welcom');
})->name('home');

require __DIR__ . '/front_web.php';

Route::get('/dashboard/login', [DashbaordController::class, 'login'])->name('login');
Route::post('/dashboard/login', [DashbaordController::class, 'post_login'])->name('post_login');
Route::get('language/{locale}', [DashbaordController::class, 'change_lang'])->name('language.switch');

Route::middleware(['auth'])->prefix('dashboard')->group(function () {
  Route::get('/', [DashbaordController::class, 'dashboard'])->name('dashboard');
  Route::get('/logout', [DashbaordController::class, 'logout'])->name('logout');
  Route::get('/edit_profile', [DashbaordController::class, 'edit_profile'])->name('edit_profile');
  Route::post('/edit_profile', [DashbaordController::class, 'edit_profile_post'])->name('edit_profile_post');
  Route::post('/add_general', [DashbaordController::class, 'add_general'])->name('add_general');
  Route::get('/popup_model', [DashbaordController::class, 'popup_model'])->name('popup_model');
  Route::get('/setting', [DashbaordController::class, 'setting'])->name('setting');
  Route::resource('categories', CategoryController::class)->except(['show']);
  Route::resource('products', ProductController::class)->except(['show']);
  Route::get('/products/ajax', [ProductController::class, 'ajaxIndex'])->name('products.ajax');
  Route::get('/categories/ajax', [CategoryController::class, 'ajaxIndex'])->name('categories.ajax');
  Route::get('/coupons/ajax', [CouponController::class, 'ajaxIndex'])->name('coupons.ajax');
  Route::resource('product_attributes', ProductAttributeController::class)->except(['show']);
  Route::resource('sliders', SliderController::class)->except(['show']);
  Route::resource('banners', BannerController::class)->except(['show']);
  Route::get('update_status_banner', [BannerController::class, 'update_status_banner'])->name('update_status_banner');
  Route::post('/banner/update-order', [BannerController::class, 'updateOrder'])->name('banners.updateOrder');

  Route::resource('features', ServiceController::class)->only(['index', 'edit', 'update']);
  Route::post('/features/update-order', [ServiceController::class, 'updateOrder'])->name('features.updateOrder');
  Route::post('/sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.updateOrder');
  Route::get('update_status_slider', [SliderController::class, 'update_status_slider'])->name('update_status_slider');

  Route::get('update_status_category', [CategoryController::class, 'update_status_category'])->name('update_status_category');
  Route::resource('coupons', CouponController::class)->except(['show']);
  Route::get('language_translate/{local}', [DashbaordController::class, 'show_translate'])->name('show_translate');
  Route::post('/languages/key_value_store', [DashbaordController::class, 'key_value_store'])->name('languages.key_value_store');
});
