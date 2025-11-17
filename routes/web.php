<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;          // Checkout Session flow
use App\Http\Controllers\StripeTokenController;     // Token/Charges flow
use App\Http\Controllers\PaywayController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\WishlistController;

Route::get('/dashboard', [HomeController::class, 'login_home'])->middleware(['auth'])->name('dashboard');

/* ----------------------- FRONT PAGE ----------------------- */
Route::get('/', [HomeController::class, 'home'])->name('home');
Route::post('/language-switch', [LanguageController::class, 'switchLanguage'])->name('language.switch');

/* ----------------------- AUTH / PROFILE ----------------------- */
Route::middleware('auth')->group(function () {
    // ✅ Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ✅ My Orders
    Route::get('/myorders', [HomeController::class, 'myorders'])->name('myorders');
    Route::get('/order/{id}', [HomeController::class, 'view_order'])->name('orders.view');

    // ✅ Direct Buy
    Route::get('/buy_now/{id}', [ProductController::class, 'buyNow'])->name('buy_now');
    Route::post('/confirm_order/{id}', [ProductController::class, 'confirmOrder'])->name('confirm_order');
});

require __DIR__ . '/auth.php';

/* ----------------------- ADMIN ----------------------- */
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');

    // 🗂️ Category management
    Route::get('/categories', [AdminController::class, 'view_category'])->name('admin.categories.index');
    Route::post('/categories/add', [AdminController::class, 'add_category'])->name('admin.categories.add');
    Route::get('/categories/delete/{id}', [AdminController::class, 'delete_category'])->name('admin.categories.delete');
    Route::get('/categories/edit/{id}', [AdminController::class, 'edit_category'])->name('admin.categories.edit');
    Route::post('/categories/update/{id}', [AdminController::class, 'update_category'])->name('admin.categories.update');

    // 📦 Product management
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminController::class, 'view_product'])->name('admin.products.index');
        Route::get('/add', [AdminController::class, 'add_product'])->name('admin.products.add');
        Route::post('/upload', [AdminController::class, 'upload_product'])->name('admin.products.upload');
        Route::get('/delete/{id}', [AdminController::class, 'delete_product'])->name('admin.products.delete');
        Route::get('/edit/{id}', [AdminController::class, 'show_edit_product'])->name('admin.products.edit');
        Route::post('/update/{id}', [AdminController::class, 'edit_product'])->name('admin.products.update');
        Route::get('/search', [AdminController::class, 'product_search'])->name('admin.products.search');
        Route::delete('/delete-image/{id}', [AdminController::class, 'deleteImage'])->name('admin.products.deleteImage');
    });

    // 📦 Orders
    Route::get('/orders', [AdminController::class, 'view_order'])->name('admin.orders.index');
    Route::get('/orders/on-the-way/{id}', [AdminController::class, 'on_the_way'])->name('admin.orders.on_the_way');
    Route::get('/orders/delivered/{id}', [AdminController::class, 'delivered'])->name('admin.orders.delivered');
    Route::get('/orders/print/{id}', [AdminController::class, 'print_pdf'])->name('admin.orders.print');

    // 🛒 Admin Cart
    Route::get('/cart-items', [AdminController::class, 'cartItems'])->name('admin.cart.index');
    Route::get('/cart/edit/{id}', [AdminController::class, 'editCart'])->name('admin.cart.edit');
    Route::post('/cart/update/{id}', [AdminController::class, 'updateCart'])->name('admin.cart.update');
    Route::get('/cart/delete/{id}', [AdminController::class, 'deleteCart'])->name('admin.cart.delete');
});

/* ----------------------- SHOP & PRODUCT ----------------------- */
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
// Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/why', [HomeController::class, 'why'])->name('why');
Route::get('/testimonial', [HomeController::class, 'testimonial'])->name('testimonial');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/product_details/{id}', [HomeController::class, 'product_details'])->name('product.details');
// routes/web.php
Route::get('/product/{slug}', [HomeController::class, 'product_details_by_slug'])->name('product.show');

/* ----------------------- SELLER ----------------------- */
Route::get('/seller', [SellerController::class, 'index'])->name('seller.index');
Route::get('/seller/{id}', [SellerController::class, 'show'])->name('seller.show');

Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{product}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

/* ----------------------- CART (USER) ----------------------- */
Route::middleware(['auth'])->group(function () {
    Route::post('/add_to_cart/{id}', [HomeController::class, 'add_to_cart'])->name('cart.add');
    Route::get('/add_to_cart/{id}', [HomeController::class, 'add_to_cart'])->name('cart.quickAdd');
    Route::get('/mycart', [HomeController::class, 'mycart'])->name('cart.index');
    Route::get('/delete_cart/{id}', [HomeController::class, 'delete_cart'])->name('cart.delete');
    Route::post('/update_cart/{id}', [HomeController::class, 'update_cart'])->name('cart.update');
    Route::post('/confirm_order', [HomeController::class, 'confirm_order'])->name('order.confirm');
});

// 🧮 AJAX
Route::get('/cart/summary', [HomeController::class, 'cartSummary'])->name('cart.summary');
Route::get('/cart/count', [HomeController::class, 'cartCount'])->name('cart.count');

/* ----------------------- STRIPE ----------------------- */
// Flow A: Token/Charges (Stripe form)
Route::get('/stripe/{amount}', [StripeTokenController::class, 'show'])->name('stripe.show');
Route::post('/stripe/{amount}', [StripeTokenController::class, 'charge'])->name('stripe.post');

// Flow B: Checkout Session (Stripe-hosted)
Route::post('/stripe/checkout', [StripeController::class, 'checkout'])->name('stripe.checkout');
Route::get('/stripe/success', [StripeController::class, 'success'])->name('stripe.success');
Route::get('/stripe/cancel', [StripeController::class, 'cancel'])->name('stripe.cancel');

/* ----------------------- ABA PAYWAY ----------------------- */
Route::prefix('payway')->group(function () {
    Route::post('/purchase', [PaywayController::class, 'purchase'])->name('payway.purchase');
    Route::post('/ipn', [PaywayController::class, 'ipn'])->name('payway.ipn');
    Route::get('/pushback', [PaywayController::class, 'pushback'])->name('payway.pushback');
});

// Simple Return Pages
Route::view('/payment/success', 'home.payment_success')->name('payment.success');
Route::view('/payment/cancel', 'home.payment_cancel')->name('payment.cancel');
