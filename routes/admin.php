<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    CategoryController,
    DashboardController,
    OrdersController,
    PlanController,
    ProductController,
    TeamMemberController,
    UserController
};


Route::prefix('admin')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/', [LoginController::class, 'create'])->name('admin.login');
        Route::get('/login', [LoginController::class, 'create'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'store'])->name('admin.login');
        Route::post('/logout', [LoginController::class, 'destroy'])->name('admin.logout');
    });
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrdersController::class, 'index'])->name('admin.orders');
            Route::get('/new', [OrdersController::class, 'newOrders'])->name('admin.orders.new');
            Route::get('/in-review', [OrdersController::class, 'reviewOrders'])->name('admin.orders.in-review');
            Route::get('/complete', [OrdersController::class, 'completeOrders'])->name('admin.orders.complete');
        });
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
            Route::get('/athlete', [UserController::class, 'athlete'])->name('admin.users.athlete');
            Route::get('/coach', [UserController::class, 'coach'])->name('admin.users.coach');
        });
        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
        });
        Route::prefix('plans')->group(function () {
            Route::get('/', [PlanController::class, 'index'])->name('admin.plans');
        });
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('admin.products');
        });
        Route::prefix('teams-members')->group(function () {
            Route::get('/', [TeamMemberController::class, 'index'])->name('admin.teams-members');
        });
        Route::prefix('profile')->group(function () {
            Route::get('/edit', [UserController::class, 'profileEdit'])->name('admin.profile.edit');
            Route::post('/update', [UserController::class, 'profileUpdate'])->name('admin.profile.update');
        });
    });
});
