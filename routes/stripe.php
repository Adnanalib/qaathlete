<?php

use App\Http\Controllers\StripeController;
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


############## STRIP ROUTES #################################################

Route::prefix('stripe')->middleware(['auth'])->group(function () {
    Route::get('/token', [StripeController::class, 'token'])->name('stripe.token');
    Route::post('/subscription/create', [StripeController::class, 'createSubscription'])->name('stripe.subscription.create');
    Route::post('/team/subscription/create', [StripeController::class, 'createTeamSubscription'])->name('stripe.team.subscription.create');
    Route::get('/cancel/subscription', [StripeController::class, 'cancelSubscription'])->name('cancel.subscription');
});


