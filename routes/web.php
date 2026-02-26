<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\CategoryController;

// 1. PUBLIC FRONTEND
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');

// 2. AUTHENTICATION
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// 3. CUSTOMER ROUTES (Authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/update-cart', [CartController::class, 'update'])->name('update.cart');
    Route::post('/update-cart-weight', [CartController::class, 'updateWeight'])->name('update.cart.weight');
    Route::delete('/remove-from-cart/{cartKey}', [CartController::class, 'remove'])->name('cart.remove');

    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order/success/{order}', [CheckoutController::class, 'success'])->name('order.success');

    Route::get('/my-orders', [CustomerOrderController::class, 'index'])->name('customer.orders');
    
    // NEW: Order details page
Route::get('/order/{order}', [CustomerOrderController::class, 'show'])->name('order.details');
    Route::get('/track-order', function () {
        return view('track-order');
    })->name('order.track');
});

// 4. ADMIN PANEL
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [OrderController::class, 'dashboardStats'])->name('dashboard');
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::patch('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::resource('products', AdminProductController::class)->except('show');
        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::get('/categories/{category}/products', [AdminCategoryController::class, 'products'])->name('categories.products');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });