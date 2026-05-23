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


    });
    
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
        Route::get('/pengguna', [UserController::class, 'index'])->name('pengguna-index');
        Route::get('/pengguna/create', [UserController::class, 'create'])->name('pengguna-create');
        Route::post('/pengguna', [UserController::class, 'store'])->name('pengguna-store');
        Route::get('/pengguna/{id}', [UserController::class, 'show'])->name('pengguna-show');
        Route::get('/pengguna/{id}/edit', [UserController::class, 'edit'])->name('pengguna-edit');
        Route::put('/pengguna/{id}', [UserController::class, 'update'])->name('pengguna-update');
        Route::delete('/pengguna/{id}', [UserController::class, 'destroy'])->name('pengguna-destroy');
        Route::patch('/pengguna/{id}/admin', [UserController::class, 'toggleAdmin'])->name('pengguna-toggle-admin');
    
        Route::get('/kitchens', [KitchenController::class, 'index'])->name('kitchens-index');
        Route::get('/kitchens/create', [KitchenController::class, 'create'])->name('kitchens-create');
        Route::post('/kitchens', [KitchenController::class, 'store'])->name('kitchens-store');
        Route::get('/kitchens/{kitchen}', [KitchenController::class, 'show'])->name('kitchens-show');
        Route::get('/kitchens/{kitchen}/edit', [KitchenController::class, 'edit'])->name('kitchens-edit');
        Route::put('/kitchens/{kitchen}', [KitchenController::class, 'update'])->name('kitchens-update');
        Route::delete('/kitchens/{kitchen}', [KitchenController::class, 'destroy'])->name('kitchens-destroy');

        Route::get('/kitchens/total' , [KitchenController::class, 'getTotalKitchen'])->name('kitchens-total');
        Route::get('/users/total' , [UserController::class, 'getTotalUsers'])->name('users-total');
});


require __DIR__.'/auth.php';
