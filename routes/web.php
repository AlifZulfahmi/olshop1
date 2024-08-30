<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [HomeController::class, 'getProducts']); // Ganti route default '/' dengan route getProducts

Route::get('/shop', [shopController::class, 'index'])->name('shop.index');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    // web.php
    Route::post('/beli/{id}', [HomeController::class, 'beli'])->name('beli');

    // Display the shopping cart
    Route::get('/shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart.index');

    // Add a product to the shopping cart
    Route::post('/shopping-cart/add/{id}', [ShoppingCartController::class, 'addToCart'])->name('shopping-cart.add');

    // Remove a product from the shopping cart
    Route::delete('/shopping-cart/remove/{id}', [ShoppingCartController::class, 'removeFromCart'])->name('shopping-cart.remove');

    Route::put('/shopping-cart/update-quantity/{id}', [ShoppingCartController::class, 'updateQuantity'])->name('shopping-cart.update-quantity');

    Route::post('/shopping-cart/handle-payment/{id}', [ShoppingCartController::class, 'handlePayment'])->name('shopping-cart.handle-payment');

    Route::post('shopping-cart/select_payment/{id}', [ShoppingCartController::class, 'selectPayment'])->name('shopping-cart.select_payment');

    Route::post('/shopping-cart/process-payment/{id}', [ShoppingCartController::class, 'processPayment'])->name('shopping-cart.process-payment');
});
