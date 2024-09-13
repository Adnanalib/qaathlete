<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\UserController;

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


Route::get('/', [LandingController::class, 'index'])->name('welcome')->middleware('guest');
Route::get('/download-qr', [LandingController::class, 'download'])->name('download-qr')->middleware('auth');
Route::get('/dashboard', [LandingController::class, 'dashboard'])->name('dashboard')->middleware('auth');
Route::get('/settings', [LandingController::class, 'settings'])->name('settings')->middleware('auth');
Route::post('/update/profile', [UserController::class, 'update'])->name('update-profile')->middleware('auth');
Route::get('/regenerate-qr', [UserController::class, 'regenerateQR'])->name('regenerate-qr')->middleware('auth');
Route::get('/profile-view/{uuid}', [UserController::class, 'profile'])->name('public-profile');
Route::get('/team-profile-view/{uuid}', [UserController::class, 'teamProfile'])->name('team-profile');
Route::post('/search/athlete-coach', [LandingController::class, 'search'])->name('search-athlete-coach');
Route::get('/search/athlete-coach', [LandingController::class, 'search'])->name('search-athlete-coach');

require __DIR__.'/auth.php';
require __DIR__.'/athlete.php';
require __DIR__.'/coach.php';
require __DIR__.'/stripe.php';
require __DIR__.'/cart.php';
require __DIR__.'/services.php';
require __DIR__.'/admin.php';
