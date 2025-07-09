<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Redirect to the appropriate dashboard based on user role
Route::middleware('auth')
->get('/dashboard', function (Request $request) {
    if ($request->user() && $request->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('home');
    }
})->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/user.php';