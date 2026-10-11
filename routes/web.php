<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/* Route::get('/bappa', [WelcomeController::class, 'index']);

Route::get('/home/{name}/{id}', [HomeController::class, 'index']);

*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [CustomAuthController::class, 'login']);
    Route::get('/register', [CustomAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [CustomAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', [CustomAuthController::class, 'defaultview'])->name('defaultview');
    Route::get('/dashboard', [CustomAuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');
    Route::resource('categories', CategoryController::class);
    Route::get('/{bid}', [WelcomeController::class, 'index']);

});
