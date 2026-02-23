<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;      // Public frontend
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;

// 1. PUBLIC FRONTEND
Route::get('/', [ProductController::class, 'index'])->name('home');

// 2. AUTHENTICATION
    Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// 3. CUSTOMER ROUTES (Authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update-cart', [CartController::class, 'update'])->name('update.cart');
    Route::delete('/remove-from-cart/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/my-orders', function() {
        return view('customer.orders');
    })->name('customer.orders');
});

// 4. ADMIN PANEL
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [OrderController::class, 'dashboardStats'])->name('dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::resource('products', AdminProductController::class)->except('show');
    Route::resource('categories', CategoryController::class)->except('show');
    // New route to show products in a category
    Route::get('/categories/{category}/products', [CategoryController::class, 'products'])->name('categories.products');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
});