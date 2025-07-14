<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
Route::get('/frontend', [FrontController::class, 'index'])->name('home');

Route::get('/ff', [FrontController::class, 'test_vue'])->name('test_vue');
Route::get('/products/{id}/modal', [FrontController::class, 'modal'])->name('products.modal');
Route::post('/register/ajax', [FrontController::class, 'ajaxRegister'])->name('register.ajax');
Route::post('/register/verify-otp', [FrontController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/resend-otp', [FrontController::class, 'resendOtp'])->name('resend.otp');
Route::post('/login/ajax', [FrontController::class, 'ajaxLogin'])->name('login.ajax');
Route::post('/login/otp-verify', [FrontController::class, 'verifyOtp'])->name('otp.verify');
Route::get('/get-sizes', [FrontController::class, 'getSizes']);
Route::get('/get-stock', [FrontController::class, 'getStock']);
Route::get('/products', [FrontController::class, 'products'])->name('products.all');
Route::get('/categories', [FrontController::class, 'categories'])->name('categories.all');
Route::get('/contactUs', [FrontController::class, 'contactUs'])->name('contactUs');
Route::post('/contact/send', [FrontController::class, 'sendContactUs'])->name('contact.send');
Route::get('/about', [FrontController::class, 'about'])->name('about');

Route::get('/product/{id}', [FrontController::class, 'product'])->name('product.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/mini', [CartController::class, 'mini']);
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/quick-search', [FrontController::class, 'quickSearch'])->name('products.quickSearch');
Route::get('/search-products', [FrontController::class, 'quickSearch'])->name('search.products');

Route::group(['middleware' => 'auth:client'], function () {
    Route::get('/client/dashboard', [FrontController::class, 'dashboard'])->name('client.dashboard');
    Route::post('/wishlist/add', [FrontController::class, 'addWishlist']);
    Route::get('/client/wishlist', [FrontController::class, 'wishlist'])->name('client.wishlist');
    Route::get('/wishlist/reload', [FrontController::class, 'reloadWishlist'])->name('client.wishlist.reload');
    Route::post('/profile/verify-otp', [FrontController::class, 'verifyPhoneOtp'])->name('profile.verifyOtp');

    Route::put('/profile', [FrontController::class, 'updateProfile'])->name('profile.update');
    Route::post('/client/logout', function () {
        Auth::guard('client')->logout();
        return redirect()->route('home'); // أو أي صفحة رئيسية
    })->name('client.logout');
});
