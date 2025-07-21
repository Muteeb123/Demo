<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Middleware\Admin;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

// Route::get('/', [ProductController::class, 'index'])->name('products.index');

Route::get('/', [ProductController::class,'index'])->name('dashboard');
    Route::get('/products', [ProductController::class, 'show'])->name('products.index');

Route::resource('products', ProductController::class)->except(['index', 'show'])->middleware(Admin::class, 'verified');
  

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/products/{product}/order', [ProductController::class, 'order'])->name('products.Order');
    Route::post('/products/{product}/PlaceOrder', [ProductController::class, 'PlaceOrder'])->name('products.PlaceOrder');
    Route::resource('/orders', OrderController::class);
});

require __DIR__.'/auth.php';
