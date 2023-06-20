<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', [UsersController::class, 'authUser'])->name('auth.user');

Route::middleware('scope:manage-customers')->group(function() {
    Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [CustomersController::class, 'show'])->name('customers.show');
    Route::post('/customers', [CustomersController::class, 'store'])->name('customers.store');
    Route::put('/customers/{id}', [CustomersController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomersController::class, 'destroy'])->name('customers.destroy');
});

Route::middleware('scope:manage-products')->group(function() {
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::put('/products/{id}/upload', [ProductsController::class, 'uploadImage'])->name('products.update.image');
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');
});

Route::middleware('scope:manage-brands')->group(function() {
    Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
    Route::get('/brands/{id}', [BrandsController::class, 'show'])->name('brands.show');
    Route::post('/brands', [BrandsController::class, 'store'])->name('brands.store');
    Route::put('/brands/{id}', [BrandsController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{id}', [BrandsController::class, 'destroy'])->name('brands.destroy');
});