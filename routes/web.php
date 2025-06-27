<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchProduk;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register Routes
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/register/seller', [AuthController::class, 'showSellerRegistrationForm'])->name('register.seller');
    Route::post('/register/seller', [AuthController::class, 'registerSeller'])->name('register.seller');

});

Route::middleware('auth')->group(function () {
    // Route untuk role:user
    Route::post('/checkout/update-status', [CheckoutController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::middleware(['role:user'])->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('dashboard');
        Route::get('/search', [SearchProduk::class, 'index'])->name('search');
        Route::get('/product-detail/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/transaksi', [CheckoutController::class, 'pesananSaya'])->name('transaksi.pesanan-saya');
        Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('transaksi.checkout');
        Route::post('/checkout-langsung', [CheckoutController::class, 'checkoutLangsung'])->name('transaksi.checkout-langsung');
        Route::get('/checkout-direct', [CheckoutController::class, 'checkoutDirect'])->name('transaksi.checkout-direct');
        Route::post('/checkout/token', [CheckoutController::class, 'getSnapToken']);
    });

    // // Route untuk role:seller
    Route::middleware(['role:seller'])->group(function () {
        Route::get('/seller/dashboard', [ProductController::class, 'dashboardSeller'])->name('seller.dashboard');
        Route::get('/product/create', [ProductController::class, 'createProduct'])->name('seller.product.create');
        Route::post('/product/create', [ProductController::class, 'storeProduct'])->name('seller.product.store');
        Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('seller.product.edit');
        Route::put('/product/{product}', [ProductController::class, 'update'])->name('seller.product.update');
        Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('seller.product.destroy');
    });

    // Logout route (semua role bisa akses)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});