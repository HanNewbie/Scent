<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\ContactController;

use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Auth\GoogleController;

use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\ResetController;

Route::get('/', [LandingPageController::class, 'index'])->name('landingpage');

Route::get('/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::get('/register', [LoginController::class, 'registerForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.submit');

Route::get('/forgot-password', [ForgotController::class, 'showForm'])->name('forgot.password');
Route::post('/forgot-password', [ForgotController::class, 'sendResetLink'])->name('forgot.password.post');
Route::get('/reset-password/{token}', [ResetController::class, 'showForm'])->name('reset.password');
Route::post('/reset-password', [ResetController::class, 'reset'])->name('reset.password.post');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/koleksi', [CollectController::class, 'index'])->name('koleksi');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

Route::prefix('user')->middleware('auth:web')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('/profile/update', [DashboardController::class, 'update'])->name('profile.update');

    Route::delete('/favorites/{product}', [FavoriteController::class, 'remove'])->name('favorites.remove');
    Route::post('/favorites/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{variant}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{variant}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{variant}', [CartController::class, 'remove'])->name('cart.remove');

    Route::get('/confirmation', [OrderController::class, 'showConfirmation'])->name('order.checkout');
    Route::post('/checkout/confirm', [OrderController::class, 'store'])->name('order.confirm');

    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/order/{id}', [OrderController::class, 'detail'])->name('order.detail');

});

Route::prefix('admin')->middleware('auth:admin')->name('admin.')->group(function () {
    Route::resource('dashboard', ProductController::class);
    Route::patch('/orders/{order}/status', [ProductController::class, 'updateStatus'])->name('orders.updateStatus');
});

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);


Route::get('/cek', function () {
    return request()->fullUrl();
});
