<?php


use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth','auth.type:super-admin,admin'])->group(function () {      // we can pass more than one parameter to the middleware auth.type

    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('products.show');         // laravel automaticly deal with id and we want to deal with slug so we used :slug to let laravel know that is slug no id

    Route::resource('cart', CartController::class);

    Route::get('checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('checkout', [CheckoutController::class, 'store']);

});


//      we defined the profile in dashboard.php
//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//
//
//});


require __DIR__.'/auth.php';

require __DIR__.'/dashboard.php';
