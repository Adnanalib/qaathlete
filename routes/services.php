<?php

use App\Http\Controllers\GoogleMapsController;
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


############## GOOGLE MAPS #################################################

Route::prefix('google')->middleware(['auth'])->group(function () {
    Route::get('/autocomplete', [GoogleMapsController::class, 'autocomplete'])->name('google.autocomplete');
});


