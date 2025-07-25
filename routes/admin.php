<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FeaturedController;


Route::name('admin.')
->middleware(['auth', 'admin'])
->prefix('admin')
->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::resource('/products', ProductController::class);
    Route::resource('/admins', AdminController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/features', [FeaturedController::class, 'index'])->name('featured.index');
    Route::post('/features', [FeaturedController::class, 'store'])->name('featured.store');
    Route::put('/features/{id}', [FeaturedController::class, 'update'])->name('featured.update');
    Route::delete('/features/{id}', [FeaturedController::class, 'destroy'])->name('featured.destroy');
});