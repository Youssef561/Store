<?php


use App\Http\Controllers\Api\ProductsController;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);
});


Route::apiResource('products',ProductsController::class);
