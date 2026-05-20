<?php

use App\Models\Kitchen;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('ingredients', IngredientController::class)
        ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard'); // Points to dashboard.blade.php
})->name('dashboard');

Route::get('/bahan-makanan', function (Request $request) {
    // 1. Fetch data required by your index.blade.php file
    $kitchens = Kitchen::all();
    $perPage = (int) $request->input('per_page', 10);
    $selectedKitchen = $request->input('kitchen') ? Kitchen::find($request->input('kitchen')) : null;
    $ingredients = Ingredient::paginate($perPage);

    // 2. Return the correct path: resources/views/ingredients/index.blade.php
    return view('ingredients.index', compact('kitchens', 'ingredients', 'selectedKitchen', 'perPage'));
    
})->name('bahan-makanan');

require __DIR__.'/auth.php';
