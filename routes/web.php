<?php

use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KitchenController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('ingredients', IngredientController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

    Route::get('/bahan-makanan', [IngredientController::class, 'index'])->name('bahan-makanan');


    Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna-index');
    Route::get('/pengguna/create', [UserController::class, 'create'])->name('pengguna-create');
    Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna-store');
    Route::get('/pengguna/{id}', [UserController::class, 'show'])->name('pengguna-show');
    Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna-edit');
    Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna-update');
    Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna-destroy');

    Route::resource('kitchens', KitchenController::class)
        ->only(['index', 'show', 'store', 'update', 'destroy']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
});


require __DIR__.'/auth.php';
