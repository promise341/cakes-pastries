<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductManagerController;
use App\Http\Controllers\CategoryManagerController;
use App\Http\Controllers\CouponManagerController;
use App\Http\Controllers\UserManagerController;
use Illuminate\Support\Facades\Route;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/faq', 'pages.faq')->name('faq');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])->name('products.reviews.store')->middleware('auth');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/verify', [CheckoutController::class, 'verify'])->name('checkout.verify');

// Order tracking
Route::get('/track-order', [CheckoutController::class, 'track'])->name('order.track');

// Wishlist
Route::post('/wishlist/{product}/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// Authentication
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset & Email Verification View Stubs
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', function() { return back(); })->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', function() { return redirect()->route('login'); })->name('password.update');
Route::get('/email/verify', [AuthController::class, 'showVerifyEmail'])->name('verification.notice');
Route::post('/email/verification-notification', function() { return back()->with('message', 'verification-link-sent'); })->name('verification.send');

// User Dashboard
Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function() {
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::put('/addresses/{address}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy'])->name('addresses.destroy');
});

// Admin Dashboard
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::post('/orders/{order}/status', [AdminDashboardController::class, 'updateStatus'])->name('orders.status');

    // Products Manager CRUD
    Route::get('/products', [ProductManagerController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductManagerController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductManagerController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductManagerController::class, 'destroy'])->name('products.destroy');

    // Categories Manager CRUD
    Route::get('/categories', [CategoryManagerController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryManagerController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryManagerController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryManagerController::class, 'destroy'])->name('categories.destroy');

    // Coupons Manager CRUD
    Route::get('/coupons', [CouponManagerController::class, 'index'])->name('coupons.index');
    Route::post('/coupons', [CouponManagerController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{coupon}', [CouponManagerController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{coupon}', [CouponManagerController::class, 'destroy'])->name('coupons.destroy');

    // Users Manager
    Route::get('/users', [UserManagerController::class, 'index'])->name('users.index');
    Route::post('/users/{user}/toggle-admin', [UserManagerController::class, 'toggleAdmin'])->name('users.toggle-admin');
    Route::delete('/users/{user}', [UserManagerController::class, 'destroy'])->name('users.destroy');
});
