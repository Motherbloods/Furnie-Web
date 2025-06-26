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
    Route::middleware(['role:user'])->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('dashboard');
        Route::get('/search', [SearchProduk::class, 'index'])->name('search');
        Route::get('/product-detail/{id}', [ProductController::class, 'show'])->name('product.show');
        Route::get('/transaksi', function () {
            return view('transaksi.pesanan-saya');
        });
        Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
        Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('transaksi.checkout');
        Route::post('/checkout/token', [CheckoutController::class, 'getSnapToken']);
        Route::post('/checkout/update-status', [CheckoutController::class, 'updateStatus']);


    });

    // // Route untuk role:seller
    Route::middleware(['role:seller'])->group(function () {
        Route::get('/seller/dashboard', [ProductController::class, 'dashboardSeller']);
    });

    // Logout route (semua role bisa akses)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});