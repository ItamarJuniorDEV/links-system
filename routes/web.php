<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// visitantes não logados
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// usuários logados
Route::middleware('auth')->group(function () {
    // logout
    Route::get('/logout', LogoutController::class)->name('logout');
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/links/create', [LinkController::class, 'create'])->name('links.create');
    Route::post('/links/create', [LinkController::class, 'store']);

    // acessa quem tem permissão - dono do link
    Route::middleware('can:atualizar,link')->group(function () {
        Route::get('/links/{link}/edit', [LinkController::class, 'edit'])->name('links.edit');
        Route::put('/links/{link}/edit', [LinkController::class, 'update']);
        Route::delete('links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
        Route::patch('/links/{link}/up', [LinkController::class, 'up'])->name('links.up');
        Route::patch('/links/{link}/down', [LinkController::class, 'down'])->name('links.down');
    });

    // acessa quem está logado - qualquer usuário
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update']);
});
