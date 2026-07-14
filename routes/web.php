<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PhotoCardController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\PhotoCardController as SellerProductController;
use App\Http\Controllers\Seller\StoreController as SellerStoreController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{photoCard:slug}', [PhotoCardController::class, 'show'])->name('photo_cards.show');
Route::get('/toko/{store:slug}', [StoreController::class, 'show'])->name('stores.show');

/*
|--------------------------------------------------------------------------
| Guest Only (Auth)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Cart & Checkout (buyer, no login required to browse cart, login for checkout)
|--------------------------------------------------------------------------
*/
Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/{photoCard}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/keranjang/{photoCard}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{photoCard}', [CartController::class, 'remove'])->name('cart.remove');

Route::middleware(['auth', 'role:buyer'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/pesanan-saya', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan-saya/{order}', [OrderController::class, 'show'])->name('orders.show');

    Route::post('/pesanan-saya/{order}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

/*
|--------------------------------------------------------------------------
| Seller Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');

    Route::get('/toko/buat', [SellerStoreController::class, 'create'])->name('store.create');
    Route::post('/toko', [SellerStoreController::class, 'store'])->name('store.store');
    Route::get('/toko/edit', [SellerStoreController::class, 'edit'])->name('store.edit');
    Route::put('/toko', [SellerStoreController::class, 'update'])->name('store.update');

    Route::resource('produk', SellerProductController::class)
        ->parameters(['produk' => 'photoCard'])
        ->names('photo_cards')
        ->except(['show']);

    Route::get('/pesanan', [SellerOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('orders.status');
});

/*
|--------------------------------------------------------------------------
| Admin Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/pengguna', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/pengguna/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    Route::get('/toko', [AdminStoreController::class, 'index'])->name('stores.index');
    Route::patch('/toko/{store}/toggle', [AdminStoreController::class, 'toggle'])->name('stores.toggle');

    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
});
