<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Models\Product;

Route::get('/', function () {
    return view('fitstoreHome');
})->name('home');

Auth::routes();

Route::view('/fitstoreHome', 'fitstoreHome')->name('fitstoreHome');


Route::get('/products/summer', function () {
    $products = Product::all();
    return view('products.summer', compact('products'));
})->name('products.summer');

Route::get('/products/winter', function () {
    $products = Product::all();
    return view('products.winter', compact('products'));
})->name('products.winter');

Route::get('/products/offer', function () {
    $products = Product::all();
    return view('products.offer', compact('products'));
})->name('products.offer');


Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::resource('products',App\Http\Controllers\ProductController::class);
});

Route::post('/products/store', [ProductController::class, 'store'])->name('products.store.custom');
Route::resource('products', ProductController::class);


// =============================
// Wishlist routes
Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/{product}', [App\Http\Controllers\WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{product}', [App\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlist.destroy');

    // Cart routes
    // In your routes/web.php
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});

// check out 
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout.view');
Route::get('/cart/checkout/success', [CartController::class, 'checkoutSuccess'])->name('cart.checkout.success');
Route::get('/cart/checkout/failure', [CartController::class, 'checkoutFailure'])->name('cart.checkout.failure');
Route::get('/cart/checkout/confirm', [CartController::class, 'checkoutConfirm'])->name('cart.checkout.confirm');
Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');

