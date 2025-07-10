<?php

use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
Route::get('/products', [FrontController::class, 'products']);
Route::get('/product/{id}', [FrontController::class, 'product'])->name('product.show');

Route::group(['middleware' => 'auth:client'], function () {
    Route::get('/client/dashboard', [FrontController::class, 'dashboard'])->name('client.dashboard');
    Route::post('/wishlist/add', [FrontController::class, 'addWishlist']);
    Route::post('/client/logout', function () {
        Auth::guard('client')->logout();
        return redirect()->route('home'); // أو أي صفحة رئيسية
    })->name('client.logout');
});
