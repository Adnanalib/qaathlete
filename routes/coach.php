<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Coach\DashboardController;
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


// register.coach





Route::prefix('coach')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'coachRegister'])->name('register.coach');
    Route::post('/register', [RegisteredUserController::class, 'coachRegister'])->name('register.coach.store');
    Route::middleware(['auth', 'coach'])->group(function () {
        Route::get('/payments', [PaymentController::class, 'coachPayment'])->name('coach.payment');
        Route::post('/payments', [PaymentController::class, 'coachPayment'])->name('coach.payment.upgrade');
        Route::middleware(['is_subscribed'])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('coach.dashboard');
            Route::get('/download-roaster', [DashboardController::class, 'downloadRoaster'])->name('roaster.download');
            Route::get('/setupTeam', [DashboardController::class, 'setupTeam'])->name('setup.team.get');
            Route::get('/viewChart', [DashboardController::class, 'viewChart'])->name('view-chart');
            Route::post('/setupTeam', [DashboardController::class, 'setupTeam'])->name('setup.team');
            Route::post('/setupTeam/store', [DashboardController::class, 'TeamMemberStore'])->name('setup.team.store');
            Route::get('/product/{uuid}', [DashboardController::class, 'productDetail'])->middleware('checkOnboarding')->name('coach.product.detail');
        });
    });
});
