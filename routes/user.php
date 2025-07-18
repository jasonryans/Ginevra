<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/shop/category/{category}', [ProductController::class, 'category'])->name('user.shop.category');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('user.products.show');

Route::middleware('auth')->group(function () {
    Route::get('/home', [ProductController::class, 'index'])->name('user.home');
    
    // Uncomment and add other user routes as needed
    // Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    // Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');
    // Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    // Route::get('/shop/category/{category}', [ProductController::class, 'category'])->name('user.shop.category');
    
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/profile/picture/edit', [\App\Http\Controllers\User\ProfilePictureController::class, 'edit'])->name('profile.picture.edit');
    // Route::post('/profile/picture', [\App\Http\Controllers\User\ProfilePictureController::class, 'update'])->name('profile.picture.update');
});