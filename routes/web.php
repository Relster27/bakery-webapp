<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BakeryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PublicMenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::get('/menu/{bakery:qr_token}', [PublicMenuController::class, 'show'])->name('menu.show');
Route::post('/menu/{bakery:qr_token}/orders', [PublicMenuController::class, 'store'])->name('menu.order.store');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/bakery/edit', [BakeryController::class, 'edit'])->name('bakery.edit');
    Route::put('/bakery', [BakeryController::class, 'update'])->name('bakery.update');

    Route::resource('products', ProductController::class)->except(['show', 'destroy']);

    Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
    Route::patch('/inventories/{inventory}', [InventoryController::class, 'update'])->name('inventories.update');

    Route::resource('customers', CustomerController::class)->except(['show', 'destroy']);

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status.update');
    Route::patch('/orders/{order}/expire', [OrderController::class, 'expire'])->name('orders.expire');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
