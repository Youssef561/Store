<?php

use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;




Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard',function(){
        return view('dashboard');
    })->name('dashboard');


                            // Category Trash
    Route::get('categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('categories/{category}/forceDelete', [CategoriesController::class, 'forceDelete'])->name('categories.forceDelete');

                            // Products Trash
    Route::get('products/trash', [ProductsController::class, 'trash'])->name('products.trash');
    Route::put('products/{product}/restore', [ProductsController::class, 'restore'])->name('products.restore');
    Route::delete('products/{product}/forceDelete', [ProductsController::class, 'forceDelete'])->name('products.forceDelete');

                            // all routes for categories
    Route::resource('dashboard/categories', CategoriesController::class)->names('dashboard.categories');

                            // all routes for categories
    Route::resource('dashboard/products', ProductsController::class)->names('dashboard.products');

                            // user Profile
    Route::get('profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile',[ProfileController::class, 'update'])->name('profile.update');


});
