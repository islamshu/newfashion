<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\ClientForgotPasswordController;
use App\Http\Controllers\FrontController;
use App\Http\Middleware\RedirectIfUnauthenticatedClient;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;

Route::get('/', [FrontController::class, 'index'])->name('home');
Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['ar', 'he'])) {
        abort(400);
    }
    session(['locale' => $locale]);
    app()->setLocale($locale);
    return redirect()->back();
});

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
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon');
Route::post('/remove-coupon', [CartController::class, 'removeCoupon'])->name('cart.removeCoupon');

Route::get('/product/{id}', [FrontController::class, 'product'])->name('product.show');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/mini', [CartController::class, 'mini']);
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/quick-search', [FrontController::class, 'quickSearch'])->name('products.quickSearch');
Route::get('/search-products', [FrontController::class, 'quickSearch'])->name('search.products');
Route::get('/order/{code}', [FrontController::class, 'order'])->name('order');

Route::post('/cart/remove-item', [CartController::class, 'removeItem'])->name('cart.removeItem');
// تتبع الطلب
Route::post('/orders/track', [FrontController::class, 'track'])->name('orders.track');
Route::get('/track', [FrontController::class, 'get_track'])->name('orders.get_track');

Route::post('/order/track', [FrontController::class, 'track_single'])->name('order.track');
Route::post('/dashboard/orders/fetch', [FrontController::class, 'fetchOrders'])->name('orders.fetch');
Route::post('/password/email', [FrontController::class, 'sendResetLinkEmail'])->name('password.email.ajax');
// عرض تفاصيل الطلب
Route::get('/orders/{order}/details', [FrontController::class, 'details'])->name('orders.details');
Route::middleware(['auth.client'])->group(function () {
    Route::get('/client/dashboard', [FrontController::class, 'dashboard'])->name('client.dashboard');
    Route::post('/wishlist/add', [FrontController::class, 'addWishlist']);
    Route::get('/client/wishlist', [FrontController::class, 'wishlist'])->name('client.wishlist');
    Route::get('/wishlist/reload', [FrontController::class, 'reloadWishlist'])->name('client.wishlist.reload');
    Route::post('/profile/verify-otp', [FrontController::class, 'verifyPhoneOtp'])->name('profile.verifyOtp');
    Route::post('/checkout-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::put('/profile', [FrontController::class, 'updateProfile'])->name('profile.update');
    Route::post('/client/logout', function () {
        Auth::guard('client')->logout();
        return redirect()->route('home'); // أو أي صفحة رئيسية
    })->name('client.logout');
});
