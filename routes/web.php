<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\shopController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderStatusController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| codingan lokal
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('cart.add');


// Route::post('/cart/add', [UserProductController::class, 'add']);
// Route::delete('/cart/remove/{productId}', [UserProductController::class, 'remove'])->name('cart.remove');
// Route::get('/cart', [UserProductController::class, 'show']);

// Route::get('/checkout', function () {
//     return view('checkout');
// })->name('checkout');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');
Route::get('/privacy-policy', function () {
    return view('pages.privacy');
})->name('Privacy');
Route::get('/terms-and-conditions', function () {
    return view('pages.term');
})->name('about');

Route::get('/product/{id}', [UserProductController::class, 'detail'])->name('detail');

Route::get('/shop', [HomeController::class, 'getProducts']); // Ganti route default '/' dengan route getProducts

Route::get('/shop', [shopController::class, 'index'])->name('shop.index');

Route::get('/home', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/laporan', [TransactionController::class, 'laporan'])->name('laporan.index');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('order-status', OrderStatusController::class);

    // web.php
    Route::post('/beli/{id}', [HomeController::class, 'beli'])->name('beli');

    // Display the shopping cart
    // Halaman keranjang belanja
    Route::get('/shopping-cart', [ShoppingCartController::class, 'index'])->name('shopping-cart.index');

    // Tambah produk ke keranjang
    Route::post('/shopping-cart/add/{id}', [ShoppingCartController::class, 'addToCart'])->name('shopping-cart.add');

    // Hapus produk dari keranjang
    Route::delete('/shopping-cart/remove/{id}', [ShoppingCartController::class, 'removeFromCart'])->name('shopping-cart.remove');

    // Perbarui kuantitas produk di keranjang
    Route::put('/shopping-cart/update-quantity/{id}', [ShoppingCartController::class, 'updateQuantity'])->name('shopping-cart.update-quantity');

    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout-process');

    // routes/web.php
    Route::post('/checkout-process', [CheckoutController::class, 'process'])->name('checkout-process');

    Route::get('/checkout/{transactionId}', [CheckoutController::class, 'showCheckout'])->name('checkout.show');

    // Halaman sukses checkout (opsional, jika Anda memerlukan halaman sukses terpisah)
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout-success');

    Route::get('/checkout/pending/{id}', [CheckoutController::class, 'pending'])->name('checkout-pending');

    Route::get('/checkout/failed/{id}', [CheckoutController::class, 'failed'])->name('checkout-failed');

    // Menampilkan transaksi pengguna
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');

    Route::get('/laporan/cetak-pdf', [TransactionController::class, 'cetakPDF'])->name('laporan.cetakPDF');

    Route::post('/invoice/generate', [TransactionController::class, 'generateInvoice'])->name('invoice.generate');

    // Route untuk menampilkan status pesanan
    Route::get('/order-status', [OrderStatusController::class, 'index'])->name('order_status.index');

    // Route untuk memperbarui status pesanan
    Route::put('/order-status/{id}', [OrderStatusController::class, 'update'])->name('order_status.update');

    // Route::put('/order_status/updateStatusPengiriman/{id}', [OrderStatusController::class, 'updateStatusPengiriman'])
    //     ->name('order_status.updateStatusPengiriman');

    Route::post('/order_status/{id}/create', [OrderStatusController::class, 'create'])->name('order_status.create');
});
