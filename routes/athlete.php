<?php

use App\Http\Controllers\Athletes\DashboardController;
use App\Http\Controllers\Athletes\OnboardingController;
use App\Http\Controllers\PaymentController;
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


Route::prefix('athletes')->middleware(['auth', 'athlete'])->group(function () {
    Route::get('/payments', [PaymentController::class, 'athletePayment'])->name('athletes.payment');
    Route::middleware(['is_subscribed'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('checkOnboarding')->name('athletes.dashboard');
        Route::get('/onboarding', [OnboardingController::class, 'index'])->name('athletes.onboarding');
        Route::get('/social-link/{id}', [OnboardingController::class, 'delete'])->name('athletes.social-link');
        Route::get('/feature-social-link/{id}', [OnboardingController::class, 'makeFeature'])->name('athletes.feature-social-link');
        Route::post('/onboarding', [OnboardingController::class, 'store'])->name('athletes.onboarding.store');
        Route::get('/profile', [OnboardingController::class, 'profile'])->middleware('checkOnboarding')->name('athletes.profile');
        Route::get('/product/{uuid}', [DashboardController::class, 'detail'])->middleware('checkOnboarding')->name('athlete.product.detail');
        Route::get('/viewChart', [DashboardController::class, 'viewChart'])->name('athletes.view-chart');
    });
});


