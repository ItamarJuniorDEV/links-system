<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});

// endpoints de visitantes
Route::middleware('guest')->group(function() {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// endpoint de logout
Route::middleware('auth')->group(function() {
    Route::get('/logout', LogoutController::class)->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');
});
