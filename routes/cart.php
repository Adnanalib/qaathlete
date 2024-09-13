<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::prefix('cart')->middleware(['auth'])->group(function () {
    Route::middleware(['is_subscribed', 'checkOnboarding'])->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.addToCart');
        Route::post('/remove-from-cart', [CartController::class, 'removeItem'])->name('cart.removeFromCart');
        Route::get('/detail', [CartController::class, 'detail'])->name('cart.detail');
        Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::post('/placeOrder', [OrderController::class, 'placeOrder'])->name('cart.placeOrder');
        Route::get('/order/success', [OrderController::class, 'orderSuccess'])->name('cart.order.success');
    });
});


