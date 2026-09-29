<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\MatchModelController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\GalleryController;

/*
|--------------------------------------------------------------------------
| Web Routes — WikCup Basketball
|--------------------------------------------------------------------------
*/

// ===== 1. Halaman Utama (Publik) =====
Route::get('/', [HomeController::class, 'index'])->name('home');

// ===== 2. Guest Routes (Hanya untuk yang belum login) =====
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

// ===== 3. Authenticated Routes (Semua yang sudah login) =====
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ===== 4. Public Resource Views (Read-Only: Index & Show) =====
Route::get('/hasil',          [MatchModelController::class, 'hasil'])->name('matches.hasil');
Route::resource('matches',    MatchModelController::class)->only(['index', 'show']);
Route::resource('teams',      TeamController::class)->only(['index', 'show']);
Route::resource('players',    PlayerController::class)->only(['index', 'show']);
Route::resource('statistics', StatisticController::class)->only(['index', 'show']);
Route::resource('galleries',  GalleryController::class)->only(['index', 'show']);

// ===== 5. Admin Routes (CRUD Data Turnamen & User Management) =====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/',               [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard',      [DashboardController::class, 'index']);
    Route::resource('users',      UserController::class);
    Route::resource('teams',      TeamController::class)->except(['index', 'show']);
    Route::resource('players',    PlayerController::class)->except(['index', 'show']);
    Route::resource('matches',    MatchModelController::class)->except(['index', 'show']);
    Route::resource('statistics', StatisticController::class)->except(['index', 'show']);
    Route::resource('galleries',  GalleryController::class)->except(['index', 'show']);
});
