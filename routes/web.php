<?php

use App\Http\Controllers\AuthController;
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
        Route::get('/', function () {
            return view('layouts.dashboard');
        })->name('user.dashboard');
    });

    // // Route untuk role:seller
    Route::middleware(['role:seller'])->group(function () {
        Route::get('/seller/dashboard', function () {
            return view('dashboard-seller');
        })->name('seller.dashboard');
    });

    // Logout route (semua role bisa akses)
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});