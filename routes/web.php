<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashbaordController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PageController;
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
  Route::get('/trake_page', [DashbaordController::class, 'trake_page'])->name('trake_page');

  Route::resource('categories', CategoryController::class)->except(['show']);
  Route::resource('products', ProductController::class);
  Route::get('/products_ajax', [ProductController::class, 'ajaxIndex'])->name('products.ajax');
  Route::get('/categories/ajax', [CategoryController::class, 'ajaxIndex'])->name('categories.ajax');
  Route::get('/coupons/ajax', [CouponController::class, 'ajaxIndex'])->name('coupons.ajax');
  Route::resource('product_attributes', ProductAttributeController::class)->except(['show']);
  Route::resource('sliders', SliderController::class)->except(['show']);
  Route::resource('banners', BannerController::class)->except(['show']);
  Route::get('update_status_banner', [BannerController::class, 'update_status_banner'])->name('update_status_banner');
  Route::post('/banner/update-order', [BannerController::class, 'updateOrder'])->name('banners.updateOrder');
  Route::get('about_page', [DashbaordController::class, 'about_page'])->name('about_page');
  Route::resource('features', ServiceController::class)->only(['index', 'edit', 'update']);
  Route::post('/features/update-order', [ServiceController::class, 'updateOrder'])->name('features.updateOrder');
  Route::post('/sliders/update-order', [SliderController::class, 'updateOrder'])->name('sliders.updateOrder');
  Route::get('update_status_slider', [SliderController::class, 'update_status_slider'])->name('update_status_slider');
  Route::get('update_status_category', [CategoryController::class, 'update_status_category'])->name('update_status_category');
  Route::get('update_status_product', [ProductController::class, 'update_status_product'])->name('update_status_product');
  Route::get('update_featured_product', [ProductController::class, 'update_featured_product'])->name('update_featured_product');
  Route::resource('coupons', CouponController::class)->except(['show']);
  Route::get('language_translate/{local}', [DashbaordController::class, 'show_translate'])->name('show_translate');
  Route::post('/languages/key_value_store', [DashbaordController::class, 'key_value_store'])->name('languages.key_value_store');
  Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
  Route::get('/orders/ajax', [OrderController::class, 'index'])->name('orders.ajax');
  Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
  Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
  Route::resource('clients', ClientController::class)->only([
    'index',
    'show',
    'edit',
    'update',
    'destroy'
  ]);
  Route::get('update_status_client', [ClientController::class, 'update_status_client'])->name('update_status_client');

  Route::get('client_ajax', [ClientController::class, 'ajax'])->name('clients.ajax');
  Route::get('/coupons/{coupon}/usages', [CouponController::class, 'usages'])->name('coupons.usages');
  Route::resource('reviews', ReviewController::class);
  Route::resource('pages', PageController::class);
  Route::resource('cities', CityController::class);
  Route::post('/orders/{order}/change-status', [OrderController::class, 'changeStatus'])
    ->name('orders.change_status');
  Route::get('client/trashed', [ClientController::class, 'trashed'])->name('clients.trashed');
  Route::put('client/{id}/restore', [ClientController::class, 'restore'])->name('clients.restore');
  Route::delete('client/{id}/force-delete', [ClientController::class, 'forceDelete'])->name('clients.forceDelete');
  Route::get('product/trashed', [ProductController::class, 'trashed'])->name('products.trashed');
  Route::put('product/{id}/restore', [ProductController::class, 'restore'])->name('products.restore');
  Route::get('product_rating/{id}', [ProductController::class, 'product_rating'])->name('product_rating');
  Route::delete('product_rating/{id}', [ProductController::class, 'delete_product_rating'])->name('products.ratings.destroy');
  Route::delete('product/{id}/force-delete', [ProductController::class, 'forceDelete'])->name('products.forceDelete');
});
